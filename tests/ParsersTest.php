<?php

use Parallel\Compliance\Parsers\AsvsParser;
use Parallel\Compliance\Parsers\WstgParser;

it('normalizes WSTG checklist JSON', function () {
    $json = json_encode([
        'categories' => [
            'Information Gathering' => [
                'id' => 'WSTG-INFO',
                'tests' => [
                    [
                        'name' => 'Fingerprint Web Server',
                        'id' => 'WSTG-INFO-02',
                        'reference' => 'https://example.com/wstg-info-02',
                        'objectives' => ['Determine the version and type of a running web server.'],
                    ],
                ],
            ],
        ],
    ]);

    $requirements = (new WstgParser)->parse($json, '4.2');

    expect($requirements)->toHaveCount(1)
        ->and($requirements[0]['id'])->toBe('OWASP_WSTG:4.2:WSTG-INFO-02')
        ->and($requirements[0]['title'])->toBe('Fingerprint Web Server')
        ->and($requirements[0]['categories'])->toBe(['Information Gathering'])
        ->and($requirements[0]['references'])->toBe(['https://example.com/wstg-info-02']);
});

it('normalizes nested ASVS JSON', function () {
    $json = json_encode([
        'Version' => '5.0.0',
        'Requirements' => [
            [
                'Name' => 'Authentication',
                'Items' => [
                    [
                        'Name' => 'Password Security',
                        'Items' => [
                            [
                                'Shortcode' => 'V2.1.1',
                                'Description' => 'Verify secure password handling.',
                                'L1' => ['Required' => true],
                                'CWE' => [521],
                                'NIST' => ['IA-5'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $requirements = (new AsvsParser)->parse($json);

    expect($requirements)->toHaveCount(1)
        ->and($requirements[0]['id'])->toBe('OWASP_ASVS:5.0.0:V2.1.1')
        ->and($requirements[0]['title'])->toBe('Verify secure password handling.')
        ->and($requirements[0]['categories'])->toBe(['Authentication', 'Password Security'])
        ->and($requirements[0]['mappings']['cwe'])->toBe(['CWE-521'])
        ->and($requirements[0]['mappings']['nist'])->toBe(['IA-5']);
});
