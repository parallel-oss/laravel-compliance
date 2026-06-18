<?php

namespace Parallel\Compliance\Scanning;

use Parallel\Compliance\ComplianceGap;

class ComplianceGapFinding
{
    public function __construct(
        public string $type,
        public string $target,
        public string $file,
        public int $startLine,
        public int $endLine,
        public string $code,
        public ComplianceGap $gap,
    ) {}
}
