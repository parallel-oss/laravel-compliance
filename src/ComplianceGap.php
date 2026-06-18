<?php

namespace Parallel\Compliance;

use Attribute;
use Illuminate\Support\Arr;
use Parallel\Compliance\Controls\Control;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ComplianceGap
{
    /** @var array<int, Control> */
    public array $controls;

    /**
     * @param  Control|array<int, Control>|null  $controls
     * @param  array<int, string>  $links
     * @param  array<string, scalar|null>  $metadata
     */
    public function __construct(
        public string $summary,
        Control|array|null $controls = null,
        public ?string $details = null,
        public ?string $remediation = null,
        public ?string $owner = null,
        public array $links = [],
        public array $metadata = [],
    ) {
        $this->controls = Arr::wrap($controls);
    }
}
