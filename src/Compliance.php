<?php

namespace Parallel\Compliance;

use Attribute;
use Parallel\Compliance\Controls\Control;
use Parallel\Compliance\Frameworks\FrameworkRequirement;
use Parallel\Compliance\Recommendations\Recommendation;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Compliance extends Evidence
{
    /** @var array<int, FrameworkRequirement|Recommendation> */
    public array $recommendations;

    public ?string $comment;

    /**
     * @param  Control|array<int, Control>|null  $controls
     * @param  FrameworkRequirement|Recommendation|array<int, FrameworkRequirement|Recommendation>|null  $requirements
     * @param  FrameworkRequirement|Recommendation|array<int, FrameworkRequirement|Recommendation>|null  $recommendations
     * @param  array<int, string>  $links
     * @param  array<string, scalar|null>  $metadata
     */
    public function __construct(
        Control|array|null $controls = null,
        FrameworkRequirement|Recommendation|array|null $requirements = null,
        ?string $summary = null,
        EvidenceStatus $status = EvidenceStatus::Implemented,
        ?string $details = null,
        array $links = [],
        array $metadata = [],
        FrameworkRequirement|Recommendation|array|null $recommendations = null,
        ?string $comment = null,
    ) {
        parent::__construct(
            controls: $controls,
            requirements: $requirements ?? $recommendations ?? [],
            summary: $summary ?? $comment,
            status: $status,
            details: $details,
            links: $links,
            metadata: $metadata,
        );

        $this->recommendations = $this->requirements;
        $this->comment = $this->summary;
    }
}
