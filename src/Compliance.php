<?php

namespace Parallel\Compliance;

use Attribute;
use Parallel\Compliance\Capabilities\Capability;
use Parallel\Compliance\Recommendations\Recommendation;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Compliance extends Evidence
{
    /** @var array<int, Recommendation> */
    public array $recommendations;

    /** @var array<int, Capability> */
    public array $claims;

    public ?string $comment;

    /**
     * @param  Recommendation|array<int, Recommendation>|null  $controls
     * @param  Capability|array<int, Capability>|null  $capabilities
     * @param  Recommendation|array<int, Recommendation>|null  $recommendations
     * @param  Capability|array<int, Capability>|null  $claims
     * @param  array<int, string>  $links
     * @param  array<string, scalar|null>  $metadata
     */
    public function __construct(
        Recommendation|array|null $controls = null,
        Capability|array|null $capabilities = null,
        ?string $summary = null,
        EvidenceStatus $status = EvidenceStatus::Implemented,
        ?string $details = null,
        array $links = [],
        array $metadata = [],
        Recommendation|array|null $recommendations = null,
        Capability|array|null $claims = null,
        ?string $comment = null,
    ) {
        parent::__construct(
            controls: $controls ?? $recommendations ?? [],
            capabilities: $capabilities ?? $claims ?? [],
            summary: $summary ?? $comment,
            status: $status,
            details: $details,
            links: $links,
            metadata: $metadata,
        );

        $this->recommendations = $this->controls;
        $this->claims = $this->capabilities;
        $this->comment = $this->summary;
    }
}
