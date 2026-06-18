<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Nette\PhpGenerator\PhpFile;
use Parallel\Compliance\Recommendations\Recommendation;

class GenerateRecommendationEnums extends Command
{
    protected $signature = 'security:generate-enums {input*} {--output=app/Enums}';

    protected $description = 'Generates PHP enums from standardized recommendation JSON files';

    public function handle()
    {
        $inputPaths = $this->argument('input');
        $outputPath = base_path($this->option('output'));

        foreach ($inputPaths as $inputPath) {
            $this->info("Processing {$inputPath}...");

            $recommendations = json_decode(file_get_contents($inputPath), true);

            if (empty($recommendations)) {
                $this->warn("No recommendations found in {$inputPath}");

                continue;
            }

            $source = $recommendations[0]['source'] ?? 'UnknownSource';
            $enumName = $this->generateEnumName($source);

            $this->generateEnumFile($recommendations, $enumName, $outputPath);
        }

        $this->info('Enums generated successfully.');
    }

    private function generateEnumName(string $source): string
    {
        // Convert source to PascalCase for enum name
        $source = str_replace(['_', '-'], ' ', $source);

        return str_replace(' ', '', ucwords(strtolower($source))).'Recommendations';
    }

    private function generateEnumFile(array $recommendations, string $enumName, string $outputPath)
    {
        $file = new PhpFile;
        $file->setStrictTypes();

        // Implement consistent namespace
        $namespace = $file->addNamespace('App\\Enums');

        // Implement the RecommendationEnum interface
        $namespace->addUse(Recommendation::class);

        $enum = $namespace->addEnum($enumName)
            ->setType('string')
            ->addImplement(Recommendation::class);

        foreach ($recommendations as $recommendation) {
            $id = $recommendation['id'];
            $name = $this->sanitizeEnumCase($id);
            $value = $id;

            // Include descriptions in enum DocBlocks
            $description = $recommendation['name'];
            if (! empty($recommendation['description'])) {
                $description .= "\n\n".$recommendation['description'];
            }

            $case = $enum->addCase($name, $value);
            $case->setComment($description);
        }

        $code = $file->__toString();

        // Ensure output directory exists
        if (! is_dir($outputPath)) {
            mkdir($outputPath, 0755, true);
        }

        $enumFilePath = $outputPath.'/'.$enumName.'.php';
        file_put_contents($enumFilePath, $code);
    }

    private function sanitizeEnumCase(string $id): string
    {
        // Replace invalid characters with underscores and ensure it starts with a letter
        $name = preg_replace('/[^a-zA-Z0-9]/', '_', $id);
        if (! preg_match('/^[a-zA-Z]/', $name)) {
            $name = 'ID_'.$name;
        }

        return strtoupper($name);
    }
}
