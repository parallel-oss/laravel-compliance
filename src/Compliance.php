<?php

namespace Parallel\Compliance;

use Attribute;
use Illuminate\Support\Arr;
use Parallel\Compliance\Recommendations\Recommendation;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Compliance
{
    /** @var Recommendation[] */
    public array $recommendations;

    /**
     * @param  Recommendation|Recommendation[]  $recommendations  One or more recommendation enum values.
     * @param  string|null  $comment  An optional comment or explanation.
     */
    public function __construct(
        Recommendation|array $recommendations,
        public ?string $comment = null
    ) {
        $this->recommendations = Arr::wrap($recommendations);
    }
}
