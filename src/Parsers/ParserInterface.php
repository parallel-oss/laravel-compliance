<?php

namespace Parallel\Compliance\Parsers;

interface ParserInterface
{
    /**
     * Parses source JSON content and returns standardized recommendation arrays.
     */
    public function parse(string $json, ?string $version = null): array;
}
