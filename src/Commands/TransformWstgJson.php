<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Parallel\Compliance\Parsers\WstgParser;

class TransformWstgJson extends Command
{
    protected $signature = 'security:transform-wstg {input} {output}';

    protected $description = 'Transforms the WSTG JSON file into the standardized format';

    public function handle()
    {
        $inputPath = $this->argument('input');
        $outputPath = $this->argument('output');

        $this->info("Transforming WSTG JSON from {$inputPath} to {$outputPath}...");

        $parser = new WstgParser;
        $recommendations = $parser->parse($inputPath);

        file_put_contents($outputPath, json_encode($recommendations, JSON_PRETTY_PRINT));

        $this->info('Transformation complete.');
    }
}
