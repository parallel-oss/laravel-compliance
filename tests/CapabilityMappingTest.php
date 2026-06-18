<?php

use Parallel\Compliance\Controls\ComplianceControl;
use Parallel\Compliance\Data\VantaComplianceData;

it('generates only curated code-facing compliance controls', function () {
    $actual = array_map(
        fn (ComplianceControl $control) => $control->name,
        ComplianceControl::cases(),
    );

    expect($actual)->toHaveCount(49)
        ->toContain('CustomerDataDeletedUponLeaving')
        ->toContain('AccessControlProceduresEstablished')
        ->toContain('DataEncryptionUtilized')
        ->not->toContain('BoardMeetingsConducted')
        ->not->toContain('BackgroundChecksPerformed')
        ->not->toContain('WhistleblowerPolicyEstablished')
        ->not->toContain('PhysicalAccessRestricted');
});

it('loads source control metadata through the generated data layer', function () {
    $record = VantaComplianceData::fromPackageResources()->control(ComplianceControl::AccessControlProceduresEstablished);

    expect(ComplianceControl::AccessControlProceduresEstablished->source())->toBe('Laravel Compliance')
        ->and(ComplianceControl::AccessControlProceduresEstablished->id())->toBe('access-control-procedures')
        ->and(ComplianceControl::AccessControlProceduresEstablished->title())->toBe('Access control procedures established')
        ->and(ComplianceControl::AccessControlProceduresEstablished->description())
        ->toContain('access control policy')
        ->and($record?->externalId)->toBe('IAC-2')
        ->and($record?->vantaId)->toBe('access-control-procedures')
        ->and($record?->source)->toBe('Vanta');
});

it('maps readable compliance controls to framework controls through seed pivots', function () {
    $data = VantaComplianceData::fromPackageResources();

    $accessControl = array_map(
        fn ($frameworkControl) => $frameworkControl->id(),
        $data->frameworkControlsForInternalControl(ComplianceControl::AccessControlProceduresEstablished),
    );

    expect($accessControl)
        ->toContain('SOC2:CC5.2')
        ->toContain('SOC2:CC6.1')
        ->toContain('SOC2:CC6.2')
        ->toContain('SOC2:CC6.3')
        ->and(array_map(
            fn ($frameworkControl) => $frameworkControl->id(),
            $data->frameworkControlsForInternalControl(ComplianceControl::CustomerDataDeletedUponLeaving),
        ))
        ->toBe(['SOC2:C1.2', 'SOC2:CC6.5']);
});

it('loads related engineering tests and filters policy checks', function () {
    $data = VantaComplianceData::fromPackageResources();

    $testKeys = array_map(
        fn ($test) => $test->key,
        $data->testsForInternalControl(ComplianceControl::DataEncryptionUtilized),
    );

    expect($testKeys)
        ->toContain('aws-dynamodb-encryption')
        ->not->toContain('approved-cryptography-policy-bsi-exists');
});
