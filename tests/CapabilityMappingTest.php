<?php

use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Data\VantaComplianceData;

it('generates only curated code-facing Vanta controls', function () {
    $actual = array_map(
        fn (VantaControl $control) => $control->value,
        VantaControl::cases(),
    );

    expect($actual)->toHaveCount(49)
        ->toContain('VANTA:DCH-1')
        ->toContain('VANTA:IAC-2')
        ->toContain('VANTA:CRY-4')
        ->not->toContain('VANTA:GOV-1')
        ->not->toContain('VANTA:HRS-1')
        ->not->toContain('VANTA:CPL-1')
        ->not->toContain('VANTA:PES-1');
});

it('loads Vanta control metadata through the generated data layer', function () {
    expect(VantaControl::IAC_2->source())->toBe('Vanta')
        ->and(VantaControl::IAC_2->externalId())->toBe('IAC-2')
        ->and(VantaControl::IAC_2->slug())->toBe('access-control-procedures')
        ->and(VantaControl::IAC_2->title())->toBe('Access control procedures established')
        ->and(VantaControl::IAC_2->description())
        ->toContain('access control policy');
});

it('maps curated Vanta controls to framework controls through seed pivots', function () {
    $data = VantaComplianceData::fromPackageResources();

    $iac2 = array_map(
        fn ($frameworkControl) => $frameworkControl->id(),
        $data->frameworkControlsForInternalControl(VantaControl::IAC_2),
    );

    expect($iac2)
        ->toContain('SOC2:CC5.2')
        ->toContain('SOC2:CC6.1')
        ->toContain('SOC2:CC6.2')
        ->toContain('SOC2:CC6.3')
        ->and(array_map(
            fn ($frameworkControl) => $frameworkControl->id(),
            $data->frameworkControlsForInternalControl(VantaControl::DCH_1),
        ))
        ->toBe(['SOC2:C1.2', 'SOC2:CC6.5']);
});

it('loads related engineering tests and filters policy checks', function () {
    $data = VantaComplianceData::fromPackageResources();

    $testKeys = array_map(
        fn ($test) => $test->key,
        $data->testsForInternalControl(VantaControl::CRY_4),
    );

    expect($testKeys)
        ->toContain('aws-dynamodb-encryption')
        ->not->toContain('approved-cryptography-policy-bsi-exists');
});
