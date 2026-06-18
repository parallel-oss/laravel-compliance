<?php

use Parallel\Compliance\Capabilities\CommonCapability;
use Parallel\Compliance\Frameworks\GdprRequirement;
use Parallel\Compliance\Frameworks\Soc2TrustServicesCriteria;

// config for Parallel/Compliance
return [
    'standards' => [
        storage_path('app/compliance/standards/*.json'),
    ],

    'scan_paths' => [
        app_path(),
        base_path('bootstrap'),
        config_path(),
        base_path('routes'),
    ],

    'report' => [
        'output' => base_path('security-evidence-report.md'),
        'include_code' => true,
    ],

    'enums' => [
        'namespace' => 'App\\Enums\\Compliance',
        'output' => app_path('Enums/Compliance'),
    ],

    'capability_mappings' => [
        CommonCapability::UserDataErasure->value => [
            GdprRequirement::Article17,
            Soc2TrustServicesCriteria::P4,
            Soc2TrustServicesCriteria::P5,
        ],
        CommonCapability::UserDataExport->value => [
            GdprRequirement::Article15,
            GdprRequirement::Article20,
            Soc2TrustServicesCriteria::P4,
        ],
        CommonCapability::ConsentCapture->value => [
            GdprRequirement::Article25,
            Soc2TrustServicesCriteria::P2,
        ],
        CommonCapability::AccessLogging->value => [
            GdprRequirement::Article30,
            GdprRequirement::Article32,
            Soc2TrustServicesCriteria::CC7,
        ],
        CommonCapability::EncryptionAtRest->value => [
            GdprRequirement::Article32,
            Soc2TrustServicesCriteria::CC6,
        ],
        CommonCapability::EncryptionInTransit->value => [
            GdprRequirement::Article32,
            Soc2TrustServicesCriteria::CC6,
        ],
    ],

    'sources' => [
        'owasp_wstg' => [
            'url' => 'https://raw.githubusercontent.com/OWASP/wstg/master/checklists/checklist.json',
            'version' => 'latest',
            'output' => storage_path('app/compliance/standards/owasp-wstg-latest.json'),
        ],
        'owasp_asvs' => [
            'url' => 'https://github.com/OWASP/ASVS/releases/download/v5.0.0_release/OWASP_Application_Security_Verification_Standard_5.0.0_en.json',
            'version' => '5.0.0',
            'output' => storage_path('app/compliance/standards/owasp-asvs-5.0.0.json'),
        ],
    ],
];
