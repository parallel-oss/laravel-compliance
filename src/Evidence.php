<?php

namespace Parallel\Compliance;

use Attribute;
use Illuminate\Support\Arr;
use Parallel\Compliance\Capabilities\Capability;
use Parallel\Compliance\Recommendations\Recommendation;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Evidence
{
    /** @var array<int, Recommendation> */
    public array $controls;

    /** @var array<int, Capability> */
    public array $capabilities;

    /**
     * @param  Recommendation|array<int, Recommendation>|null  $controls
     * @param  Capability|array<int, Capability>|null  $capabilities
     * @param  array<int, string>  $links
     * @param  array<string, scalar|null>  $metadata
     */
    public function __construct(
        Recommendation|array|null $controls = null,
        Capability|array|null $capabilities = null,
        public ?string $summary = null,
        public EvidenceStatus $status = EvidenceStatus::Implemented,
        public ?string $details = null,
        public array $links = [],
        public array $metadata = [],
    ) {
        $this->controls = Arr::wrap($controls);
        $this->capabilities = Arr::wrap($capabilities);
    }
}
