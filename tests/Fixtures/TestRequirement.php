<?php

namespace Parallel\Compliance\Tests\Fixtures;

use Parallel\Compliance\Recommendations\Recommendation;

enum TestRequirement: string implements Recommendation
{
    case Example = 'TEST:1:EXAMPLE';
}
