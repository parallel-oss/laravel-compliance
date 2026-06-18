<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Parallel\Compliance\Parsers\AsvsParser;

class TransformAsvsJson extends Command
{
    protected $signature = 'security:transform-asvs {input} {output}';

    protected $description = 'Transforms the ASVS JSON file into the standardized format';

    public function handle()
    {
        $inputPath = $this->argument('input');
        $outputPath = $this->argument('output');

        $this->info("Transforming ASVS JSON from {$inputPath} to {$outputPath}...");

        $parser = new AsvsParser;
        $recommendations = $parser->parse($inputPath);

        file_put_contents($outputPath, json_encode($recommendations, JSON_PRETTY_PRINT));

        $this->info('Transformation complete.');
    }
}
