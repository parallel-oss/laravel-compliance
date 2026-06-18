<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Parallel\Compliance\Parsers\WstgParser;

class TransformWstgJson extends Command
{
    protected $signature = 'security:import-wstg
        {--output= : Output JSON file}
        {--url= : Source WSTG checklist JSON URL}
        {--source-version= : Source version label}';

    protected $description = 'Downloads WSTG checklist JSON and transforms it into standardized requirement JSON';

    protected $aliases = ['security:transform-wstg'];

    public function handle(): int
    {
        $url = $this->option('url') ?: config('compliance.sources.owasp_wstg.url');
        $version = $this->option('source-version') ?: config('compliance.sources.owasp_wstg.version');
        $outputPath = $this->option('output') ?: config('compliance.sources.owasp_wstg.output');

        $this->info("Downloading WSTG JSON from {$url}...");

        $json = file_get_contents($url);

        if ($json === false) {
            $this->error("Unable to download WSTG JSON from {$url}.");

            return self::FAILURE;
        }

        $recommendations = (new WstgParser)->parse($json, $version);

        $this->writeJson($outputPath, $recommendations);

        $this->info("Imported {$this->sourceCount($recommendations)} WSTG requirements to {$outputPath}.");

        return self::SUCCESS;
    }

    private function writeJson(string $outputPath, array $recommendations): void
    {
        $directory = dirname($outputPath);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($outputPath, json_encode($recommendations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL);
    }

    private function sourceCount(array $recommendations): int
    {
        return count($recommendations);
    }
}
