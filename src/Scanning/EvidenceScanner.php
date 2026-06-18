<?php

namespace Parallel\Compliance\Scanning;

use Parallel\Compliance\Compliance;
use Parallel\Compliance\Evidence;
use PhpParser\Error;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionAttribute;
use ReflectionClass;

class EvidenceScanner
{
    /** @var array<int, class-string<Evidence>> */
    private array $attributeClasses = [
        Evidence::class,
        Compliance::class,
    ];

    /**
     * @param  array<int, string>  $paths
     * @return array<int, EvidenceFinding>
     */
    public function scan(array $paths): array
    {
        $findings = [];

        foreach ($this->phpFiles($paths) as $file) {
            $findings = [
                ...$findings,
                ...$this->scanFile($file),
            ];
        }

        return $findings;
    }

    /**
     * @return array<int, EvidenceFinding>
     */
    private function scanFile(string $file): array
    {
        $code = file_get_contents($file);

        if ($code === false) {
            return [];
        }

        $parser = (new ParserFactory)->createForNewestSupportedVersion();
        try {
            $statements = $parser->parse($code);
        } catch (Error) {
            return [];
        }

        if ($statements === null) {
            return [];
        }

        $traverser = new NodeTraverser;
        $traverser->addVisitor(new NameResolver);
        $statements = $traverser->traverse($statements);

        $finder = new NodeFinder;
        $classes = $finder->findInstanceOf($statements, ClassLike::class);
        $lines = preg_split('/\R/', $code);
        $findings = [];

        foreach ($classes as $classNode) {
            if (! isset($classNode->namespacedName)) {
                continue;
            }

            $className = $classNode->namespacedName->toString();

            if (! class_exists($className)) {
                continue;
            }

            $reflectionClass = new ReflectionClass($className);
            $findings = [
                ...$findings,
                ...$this->classFindings($reflectionClass, $classNode, $file, $lines),
                ...$this->methodFindings($reflectionClass, $classNode, $file, $lines),
            ];
        }

        return $findings;
    }

    /**
     * @param  array<int, string>  $lines
     * @return array<int, EvidenceFinding>
     */
    private function classFindings(ReflectionClass $reflectionClass, ClassLike $classNode, string $file, array $lines): array
    {
        if (! $this->hasEvidenceAttribute($classNode)) {
            return [];
        }

        return array_map(
            fn (Evidence $evidence) => new EvidenceFinding(
                type: 'class',
                target: $reflectionClass->getName(),
                file: $file,
                startLine: $this->startLine($classNode),
                endLine: $classNode->getEndLine(),
                code: $this->snippet($lines, $this->startLine($classNode), $classNode->getEndLine()),
                evidence: $evidence,
            ),
            $this->evidenceAttributes($reflectionClass)
        );
    }

    /**
     * @param  array<int, string>  $lines
     * @return array<int, EvidenceFinding>
     */
    private function methodFindings(ReflectionClass $reflectionClass, ClassLike $classNode, string $file, array $lines): array
    {
        $findings = [];

        foreach ($classNode->getMethods() as $methodNode) {
            if (! $this->hasEvidenceAttribute($methodNode)) {
                continue;
            }

            if (! $reflectionClass->hasMethod($methodNode->name->toString())) {
                continue;
            }

            $reflectionMethod = $reflectionClass->getMethod($methodNode->name->toString());

            foreach ($this->evidenceAttributes($reflectionMethod) as $evidence) {
                $findings[] = new EvidenceFinding(
                    type: 'method',
                    target: $reflectionClass->getName().'::'.$reflectionMethod->getName().'()',
                    file: $file,
                    startLine: $this->startLine($methodNode),
                    endLine: $methodNode->getEndLine(),
                    code: $this->snippet($lines, $this->startLine($methodNode), $methodNode->getEndLine()),
                    evidence: $evidence,
                );
            }
        }

        return $findings;
    }

    /**
     * @return array<int, Evidence>
     */
    private function evidenceAttributes(ReflectionClass|\ReflectionMethod $reflection): array
    {
        $instances = [];

        foreach ($reflection->getAttributes(Evidence::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $instances[] = $attribute->newInstance();
        }

        return $instances;
    }

    private function hasEvidenceAttribute(ClassLike|ClassMethod $node): bool
    {
        foreach ($node->attrGroups as $attributeGroup) {
            foreach ($attributeGroup->attrs as $attribute) {
                if ($this->isEvidenceAttribute($attribute)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isEvidenceAttribute(Node\Attribute $attribute): bool
    {
        $name = ltrim($attribute->name->toString(), '\\');
        $shortName = class_basename($name);

        foreach ($this->attributeClasses as $attributeClass) {
            if ($name === $attributeClass || $shortName === class_basename($attributeClass)) {
                return true;
            }
        }

        return false;
    }

    private function startLine(ClassLike|ClassMethod $node): int
    {
        $startLine = $node->getStartLine();

        foreach ($node->attrGroups as $attributeGroup) {
            foreach ($attributeGroup->attrs as $attribute) {
                if ($this->isEvidenceAttribute($attribute)) {
                    $startLine = min($startLine, $attributeGroup->getStartLine());
                }
            }
        }

        return $startLine;
    }

    /**
     * @param  array<int, string>  $lines
     */
    private function snippet(array $lines, int $startLine, int $endLine): string
    {
        return implode("\n", array_slice($lines, $startLine - 1, $endLine - $startLine + 1));
    }

    /**
     * @param  array<int, string>  $paths
     * @return array<int, string>
     */
    private function phpFiles(array $paths): array
    {
        $files = [];

        foreach ($paths as $path) {
            foreach (glob($path, GLOB_BRACE) ?: [] as $resolvedPath) {
                if (is_file($resolvedPath) && pathinfo($resolvedPath, PATHINFO_EXTENSION) === 'php') {
                    $files[] = $resolvedPath;
                }

                if (! is_dir($resolvedPath)) {
                    continue;
                }

                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($resolvedPath));

                foreach ($iterator as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $files[] = $file->getPathname();
                    }
                }
            }
        }

        return array_values(array_unique($files));
    }
}
