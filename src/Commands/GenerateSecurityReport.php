<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Parallel\Compliance\Compliance;
use Parallel\Compliance\Recommendations\RecommendationCollection;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionMethod;

class GenerateSecurityReport extends Command
{
    protected $signature = 'security:generate-report';

    protected $description = 'Generates a Markdown report of security compliance annotations found in the project';

    private RecommendationCollection $recommendationCollection;

    public function handle()
    {
        $this->info('Scanning for security compliance annotations...');

        // Load recommendations
        $this->recommendationCollection = new RecommendationCollection;
        $this->recommendationCollection->loadFromFile(storage_path('recommendations_wstg.json'));
        $this->recommendationCollection->loadFromFile(storage_path('recommendations_asvs.json'));

        $directories = [
            app_path(),
            base_path('bootstrap'),
            config_path(),
        ];

        $reportData = [];

        foreach ($directories as $directory) {
            $files = $this->getPhpFiles($directory);

            foreach ($files as $file) {
                $classes = $this->getClassesFromFile($file);

                foreach ($classes as $className) {
                    if (! class_exists($className)) {
                        continue;
                    }

                    $reflectionClass = new ReflectionClass($className);

                    // Check for class-level annotations
                    $classAttributes = $reflectionClass->getAttributes(Compliance::class);

                    foreach ($classAttributes as $attribute) {
                        /** @var Compliance $attributeInstance */
                        $attributeInstance = $attribute->newInstance();
                        $codeInfo = $this->getClassCode($reflectionClass);

                        $reportData[] = [
                            'type' => 'Class',
                            'recommendations' => $attributeInstance->recommendations,
                            'comment' => $attributeInstance->comment,
                            'code' => $codeInfo['code'],
                            'file' => $codeInfo['file'],
                            'start_line' => $codeInfo['start_line'],
                        ];
                    }

                    // Check for method-level annotations
                    $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE);

                    foreach ($methods as $method) {
                        $methodAttributes = $method->getAttributes(Compliance::class);

                        foreach ($methodAttributes as $attribute) {
                            /** @var Compliance $attributeInstance */
                            $attributeInstance = $attribute->newInstance();
                            $codeInfo = $this->getMethodCode($method);

                            $reportData[] = [
                                'type' => 'Method',
                                'recommendations' => $attributeInstance->recommendations,
                                'comment' => $attributeInstance->comment,
                                'code' => $codeInfo['code'],
                                'file' => $codeInfo['file'],
                                'start_line' => $codeInfo['start_line'],
                            ];
                        }
                    }
                }
            }
        }

        $this->generateMarkdownReport($reportData);

        $this->info('Security compliance report generated successfully.');
    }

    private function getPhpFiles($directory)
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $files = [];

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function getClassesFromFile($file)
    {
        $classes = [];
        $namespace = null;
        $tokens = token_get_all(file_get_contents($file));

        for ($i = 0; $i < count($tokens); $i++) {
            if (! isset($tokens[$i][0])) {
                continue;
            }

            if ($tokens[$i][0] === T_NAMESPACE) {
                $namespace = '';
                $i += 2; // Skip 'namespace' and whitespace

                while ($tokens[$i][0] === T_STRING || $tokens[$i][0] === T_NS_SEPARATOR) {
                    $namespace .= $tokens[$i++][1];
                }
            }

            if ($tokens[$i][0] === T_CLASS && $tokens[$i - 1][0] !== T_DOUBLE_COLON) {
                $i += 2; // Skip 'class' and whitespace
                $className = $tokens[$i][1];

                if ($namespace) {
                    $classes[] = $namespace.'\\'.$className;
                } else {
                    $classes[] = $className;
                }
            }
        }

        return $classes;
    }

    private function getClassCode(ReflectionClass $class)
    {
        $fileName = $class->getFileName();
        $startLine = $class->getStartLine();
        $endLine = $class->getEndLine();

        $code = $this->getCodeSnippet($fileName, $startLine, $endLine);

        return [
            'code' => $code,
            'file' => $fileName,
            'start_line' => $startLine,
        ];
    }

    private function getMethodCode(ReflectionMethod $method)
    {
        $fileName = $method->getFileName();
        $startLine = $method->getStartLine();
        $endLine = $method->getEndLine();

        $code = $this->getCodeSnippet($fileName, $startLine, $endLine);

        return [
            'code' => $code,
            'file' => $fileName,
            'start_line' => $startLine,
        ];
    }

    private function getCodeSnippet($fileName, $startLine, $endLine)
    {
        $file = new \SplFileObject($fileName);
        $file->seek($startLine - 1);

        $code = '';
        for ($i = $startLine; $i <= $endLine; $i++) {
            $code .= $file->current();
            $file->next();
        }

        return $code;
    }

    private function generateMarkdownReport(array $reportData)
    {
        $markdown = "# Security Compliance Report\n\n";

        foreach ($reportData as $data) {
            foreach ($data['recommendations'] as $recommendationEnum) {
                $recommendationId = $recommendationEnum->value;
                $recommendation = $this->recommendationCollection->getById($recommendationId);

                $markdown .= "## Recommendation: {$recommendation->name}\n";
                $markdown .= "### Source: {$recommendation->source}\n";
                $markdown .= "### ID: {$recommendation->id}\n";
                $markdown .= "### Type: {$data['type']}\n";
                $markdown .= "### File: {$data['file']} (Line {$data['start_line']})\n\n";

                if (! empty($recommendation->description)) {
                    $markdown .= "#### Description\n";
                    $markdown .= "{$recommendation->description}\n\n";
                }

                if (! empty($recommendation->reference)) {
                    $markdown .= "#### Reference\n";
                    $markdown .= "[{$recommendation->reference}]({$recommendation->reference})\n\n";
                }

                if (! empty($data['comment'])) {
                    $markdown .= "#### Comment\n";
                    $markdown .= "{$data['comment']}\n\n";
                }

                $markdown .= "#### Code\n";
                $markdown .= "```php\n";
                $markdown .= $data['code'];
                $markdown .= "\n```\n\n";
            }
        }

        file_put_contents(base_path('security_compliance_report.md'), $markdown);
    }
}
