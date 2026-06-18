<?php

namespace Parallel\Compliance\Scanning;

use Parallel\Compliance\Evidence;

class EvidenceFinding
{
    public function __construct(
        public string $type,
        public string $target,
        public string $file,
        public int $startLine,
        public int $endLine,
        public string $code,
        public Evidence $evidence,
    ) {}
}
