<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Nette\PhpGenerator\PhpFile;
use Parallel\Compliance\Recommendations\Recommendation;

class GenerateRecommendationEnums extends Command
{
    protected $signature = 'security:generate-enums
        {input* : Standardized recommendation JSON files}
        {--output= : Directory where enums should be written}
        {--namespace= : Namespace for generated enums}';

    protected $description = 'Generates PHP enums from standardized recommendation JSON files';

    public function handle(): int
    {
        $inputPaths = $this->inputPaths();
        $outputPath = $this->option('output') ?: config('compliance.enums.output');
        $namespaceName = $this->option('namespace') ?: config('compliance.enums.namespace');

        foreach ($inputPaths as $inputPath) {
            $this->info("Processing {$inputPath}...");

            $recommendations = json_decode(file_get_contents($inputPath), true);

            if (empty($recommendations)) {
                $this->warn("No recommendations found in {$inputPath}");

                continue;
            }

            $source = $recommendations[0]['source'] ?? 'UnknownSource';
            $version = $recommendations[0]['source_version'] ?? null;
            $enumName = $this->generateEnumName($source, $version);

            $this->generateEnumFile($recommendations, $enumName, $namespaceName, $outputPath);
        }

        $this->info('Enums generated successfully.');

        return self::SUCCESS;
    }

    /**
     * @return array<int, string>
     */
    private function inputPaths(): array
    {
        $inputs = $this->argument('input') ?: config('compliance.standards', []);
        $paths = [];

        foreach ($inputs as $input) {
            $paths = [...$paths, ...(glob($input) ?: [])];
        }

        return array_values(array_unique($paths));
    }

    private function generateEnumName(string $source, ?string $version): string
    {
        $name = $source;

        if ($version) {
            $name .= '_'.$version;
        }

        $name = preg_replace('/[^a-zA-Z0-9]+/', ' ', $name) ?: 'Requirements';

        return str_replace(' ', '', ucwords(strtolower($name))).'Requirements';
    }

    private function generateEnumFile(array $recommendations, string $enumName, string $namespaceName, string $outputPath): void
    {
        $file = new PhpFile;
        $file->setStrictTypes();

        $namespace = $file->addNamespace($namespaceName);

        $namespace->addUse(Recommendation::class);

        $enum = $namespace->addEnum($enumName)
            ->setType('string')
            ->addImplement(Recommendation::class);

        $usedNames = [];

        foreach ($recommendations as $recommendation) {
            $id = $recommendation['id'];
            $name = $this->uniqueCaseName($this->sanitizeEnumCase($recommendation['source_id'] ?? $id), $usedNames);
            $value = $id;

            $description = $recommendation['title'] ?? $recommendation['name'] ?? $id;
            if (! empty($recommendation['description'])) {
                $description .= "\n\n".$recommendation['description'];
            }

            $case = $enum->addCase($name, $value);
            $case->setComment($description);
        }

        $code = $file->__toString();

        if (! is_dir($outputPath)) {
            mkdir($outputPath, 0755, true);
        }

        $enumFilePath = $outputPath.'/'.$enumName.'.php';
        file_put_contents($enumFilePath, $code);
    }

    private function sanitizeEnumCase(string $id): string
    {
        $name = preg_replace('/[^a-zA-Z0-9]/', '_', $id);
        if (! preg_match('/^[a-zA-Z]/', $name)) {
            $name = 'ID_'.$name;
        }

        return strtoupper($name);
    }

    /**
     * @param  array<string, true>  $usedNames
     */
    private function uniqueCaseName(string $name, array &$usedNames): string
    {
        $candidate = $name;
        $suffix = 2;

        while (isset($usedNames[$candidate])) {
            $candidate = $name.'_'.$suffix++;
        }

        $usedNames[$candidate] = true;

        return $candidate;
    }
}
