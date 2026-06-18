<?php

// config for Parallel/Compliance
return [
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
];
