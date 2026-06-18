<?php

namespace Parallel\Compliance;

enum EvidenceStatus: string
{
    case Implemented = 'implemented';
    case Partial = 'partial';
    case Planned = 'planned';
    case NotApplicable = 'not_applicable';
}
