<?php

namespace Parallel\Compliance;

use Attribute;
use Illuminate\Support\Arr;
use Parallel\Compliance\Controls\Control;
use Parallel\Compliance\Frameworks\FrameworkRequirement;
use Parallel\Compliance\Recommendations\Recommendation;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Evidence
{
    /** @var array<int, Control> */
    public array $controls;

    /** @var array<int, FrameworkRequirement|Recommendation> */
    public array $requirements;

    /**
     * @param  Control|array<int, Control>|null  $controls
     * @param  FrameworkRequirement|Recommendation|array<int, FrameworkRequirement|Recommendation>|null  $requirements
     * @param  array<int, string>  $links
     * @param  array<string, scalar|null>  $metadata
     */
    public function __construct(
        Control|array|null $controls = null,
        FrameworkRequirement|Recommendation|array|null $requirements = null,
        public ?string $summary = null,
        public EvidenceStatus $status = EvidenceStatus::Implemented,
        public ?string $details = null,
        public array $links = [],
        public array $metadata = [],
    ) {
        $this->controls = Arr::wrap($controls);
        $this->requirements = Arr::wrap($requirements);
    }
}
