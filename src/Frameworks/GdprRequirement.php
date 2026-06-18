<?php

namespace Parallel\Compliance\Frameworks;

enum GdprRequirement: string implements FrameworkRequirement
{
    case Article5 = 'GDPR:Article 5';
    case Article6 = 'GDPR:Article 6';
    case Article7 = 'GDPR:Article 7';
    case Article12 = 'GDPR:Article 12';
    case Article13 = 'GDPR:Article 13';
    case Article14 = 'GDPR:Article 14';
    case Article15 = 'GDPR:Article 15';
    case Article16 = 'GDPR:Article 16';
    case Article17 = 'GDPR:Article 17';
    case Article18 = 'GDPR:Article 18';
    case Article19 = 'GDPR:Article 19';
    case Article20 = 'GDPR:Article 20';
    case Article21 = 'GDPR:Article 21';
    case Article24 = 'GDPR:Article 24';
    case Article25 = 'GDPR:Article 25';
    case Article28 = 'GDPR:Article 28';
    case Article30 = 'GDPR:Article 30';
    case Article32 = 'GDPR:Article 32';
    case Article33 = 'GDPR:Article 33';
    case Article34 = 'GDPR:Article 34';
    case Article35 = 'GDPR:Article 35';
}
