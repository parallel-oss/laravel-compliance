<?php

namespace Parallel\Compliance\Frameworks;

enum GdprRequirement: string implements FrameworkRequirement
{
    case Article15 = 'GDPR:Article 15';
    case Article17 = 'GDPR:Article 17';
    case Article20 = 'GDPR:Article 20';
    case Article25 = 'GDPR:Article 25';
    case Article30 = 'GDPR:Article 30';
    case Article32 = 'GDPR:Article 32';
}
