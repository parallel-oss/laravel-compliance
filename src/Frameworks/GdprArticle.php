<?php

namespace Parallel\Compliance\Frameworks;

enum GdprArticle: string implements FrameworkRequirement
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

    public function id(): string
    {
        return $this->value;
    }

    public function source(): string
    {
        return 'GDPR';
    }

    public function title(): string
    {
        return match ($this) {
            self::Article5 => 'Principles relating to processing of personal data',
            self::Article6 => 'Lawfulness of processing',
            self::Article7 => 'Conditions for consent',
            self::Article12 => 'Transparent information, communication and modalities',
            self::Article13 => 'Information where personal data are collected from the data subject',
            self::Article14 => 'Information where personal data have not been obtained from the data subject',
            self::Article15 => 'Right of access',
            self::Article16 => 'Right to rectification',
            self::Article17 => 'Right to erasure',
            self::Article18 => 'Right to restriction of processing',
            self::Article19 => 'Notification obligation regarding rectification, erasure, or restriction',
            self::Article20 => 'Right to data portability',
            self::Article21 => 'Right to object',
            self::Article24 => 'Responsibility of the controller',
            self::Article25 => 'Data protection by design and by default',
            self::Article28 => 'Processor obligations',
            self::Article30 => 'Records of processing activities',
            self::Article32 => 'Security of processing',
            self::Article33 => 'Notification of a personal data breach to the supervisory authority',
            self::Article34 => 'Communication of a personal data breach to the data subject',
            self::Article35 => 'Data protection impact assessment',
        };
    }

    public function description(): ?string
    {
        return null;
    }

    public function domain(): string
    {
        return 'Data protection';
    }
}
