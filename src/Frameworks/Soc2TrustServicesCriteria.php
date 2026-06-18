<?php

namespace Parallel\Compliance\Frameworks;

enum Soc2TrustServicesCriteria: string implements FrameworkRequirement
{
    case CC6 = 'SOC2:CC6';
    case CC7 = 'SOC2:CC7';
    case CC8 = 'SOC2:CC8';
    case C1 = 'SOC2:C1';
    case P1 = 'SOC2:P1';
    case P2 = 'SOC2:P2';
    case P4 = 'SOC2:P4';
    case P5 = 'SOC2:P5';
}
