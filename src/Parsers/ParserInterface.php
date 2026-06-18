<?php

namespace Parallel\Compliance\Parsers;

interface ParserInterface
{
    /**
     * Parses the source JSON file and returns an array of standardized recommendations.
     */
    public function parse(string $filePath): array;
}
