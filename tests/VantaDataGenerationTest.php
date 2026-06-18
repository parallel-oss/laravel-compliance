<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::deleteDirectory(storage_path('framework/testing/vanta-data'));
    File::delete(storage_path('framework/testing/ComplianceControl.php'));
});

it('generates curated seedable Vanta data from package resources', function () {
    $output = storage_path('framework/testing/vanta-data');
    $enumOutput = storage_path('framework/testing/ComplianceControl.php');

    $this->artisan('security:generate-vanta-data', [
        '--output' => $output,
        '--control-enum-output' => $enumOutput,
    ])->assertSuccessful();

    $frameworks = require $output.'/frameworks.php';
    $frameworkControls = require $output.'/framework-controls.php';
    $internalControls = require $output.'/internal-controls.php';
    $tests = require $output.'/tests.php';
    $frameworkControlInternalControl = require $output.'/framework-control-internal-control.php';
    $internalControlTest = require $output.'/internal-control-test.php';

    expect($frameworks)->toHaveCount(count(glob(package_vanta_path('raw/*.json')) ?: []))
        ->and($frameworkControls)->toHaveCount(raw_vanta_section_count())
        ->and($internalControls)->not->toBeEmpty()
        ->and($tests)->not->toBeEmpty();

    $internalControlExternalIds = array_column($internalControls, 'external_id');

    expect($internalControlExternalIds)
        ->toContain('DCH-1')
        ->toContain('IAC-2')
        ->toContain('CRY-4')
        ->not->toContain('GOV-1')
        ->not->toContain('HRS-1')
        ->not->toContain('CPL-1')
        ->not->toContain('PES-1');

    $testKeys = array_column($tests, 'key');

    expect($testKeys)
        ->toContain('github-ensure-branch-protection-enforced')
        ->not->toContain('approved-code-of-conduct-bsi-exists')
        ->not->toContain('approved-cryptography-policy-bsi-exists');

    expect($enumOutput)->toBeFile()
        ->and(file_get_contents($enumOutput))->toContain('enum ComplianceControl: string implements Control')
        ->and(file_get_contents($enumOutput))->toContain('case CustomerDataDeletedUponLeaving = \'customer-data-deleted-upon-leave\';')
        ->and(file_get_contents($enumOutput))->not->toContain('case BoardMeetingsConducted')
        ->and(file_get_contents($enumOutput))->not->toContain('case BackgroundChecksPerformed');

    assert_vanta_pivots_are_referentially_integral(
        $frameworkControls,
        $internalControls,
        $tests,
        $frameworkControlInternalControl,
        $internalControlTest,
    );
});

it('keeps generated Vanta seed files checked in', function () {
    foreach ([
        'frameworks',
        'framework-controls',
        'internal-controls',
        'tests',
        'integrations',
        'framework-control-internal-control',
        'internal-control-test',
        'integration-test',
        'test-entities',
    ] as $name) {
        expect(package_vanta_path("data/{$name}.php"))->toBeFile();
    }
});

function package_vanta_path(string $path = ''): string
{
    $base = dirname(__DIR__).'/resources/frameworks/vanta';

    return $path === '' ? $base : $base.'/'.$path;
}

function raw_vanta_section_count(): int
{
    $count = 0;

    foreach (glob(package_vanta_path('raw/*.json')) ?: [] as $file) {
        $payload = json_decode((string) file_get_contents($file), true);

        foreach (($payload['principles'] ?? []) as $principle) {
            $count += count($principle['sections'] ?? []);
        }
    }

    return $count;
}

/**
 * @param  array<int, array<string, mixed>>  $frameworkControls
 * @param  array<int, array<string, mixed>>  $internalControls
 * @param  array<int, array<string, mixed>>  $tests
 * @param  array<int, array<string, mixed>>  $frameworkControlInternalControl
 * @param  array<int, array<string, mixed>>  $internalControlTest
 */
function assert_vanta_pivots_are_referentially_integral(
    array $frameworkControls,
    array $internalControls,
    array $tests,
    array $frameworkControlInternalControl,
    array $internalControlTest,
): void {
    $frameworkControlKeys = array_fill_keys(array_map(
        fn (array $row): string => $row['framework_slug'].'|'.$row['code'],
        $frameworkControls,
    ), true);
    $internalControlExternalIds = array_fill_keys(array_column($internalControls, 'external_id'), true);
    $internalControlVantaIds = array_fill_keys(array_column($internalControls, 'vanta_id'), true);
    $testKeys = array_fill_keys(array_column($tests, 'key'), true);

    foreach ($frameworkControlInternalControl as $pivot) {
        expect($frameworkControlKeys)->toHaveKey($pivot['framework_slug'].'|'.$pivot['framework_control_code'])
            ->and($internalControlExternalIds)->toHaveKey($pivot['internal_control_external_id'])
            ->and($internalControlVantaIds)->toHaveKey($pivot['internal_control_vanta_id']);
    }

    foreach ($internalControlTest as $pivot) {
        expect($internalControlVantaIds)->toHaveKey($pivot['internal_control_vanta_id'])
            ->and($testKeys)->toHaveKey($pivot['test_key']);
    }
}
