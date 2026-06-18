<?php

namespace Parallel\Compliance\Data;

use BackedEnum;

class VantaComplianceData
{
    /** @var array<string, FrameworkRecord> */
    private array $frameworksBySlug = [];

    /** @var array<string, FrameworkControlRecord> */
    private array $frameworkControlsByKey = [];

    /** @var array<string, ControlRecord> */
    private array $controlsByVantaId = [];

    /** @var array<string, ControlRecord> */
    private array $controlsByExternalId = [];

    /** @var array<string, TestRecord> */
    private array $testsByKey = [];

    /** @var array<int, array<string, mixed>> */
    private array $frameworkControlInternalControl = [];

    /** @var array<int, array<string, string>> */
    private array $internalControlTest = [];

    /**
     * @param  array<int, array<string, mixed>>  $frameworks
     * @param  array<int, array<string, mixed>>  $frameworkControls
     * @param  array<int, array<string, mixed>>  $internalControls
     * @param  array<int, array<string, mixed>>  $tests
     * @param  array<int, array<string, mixed>>  $frameworkControlInternalControl
     * @param  array<int, array<string, string>>  $internalControlTest
     */
    public function __construct(
        array $frameworks,
        array $frameworkControls,
        array $internalControls,
        array $tests,
        array $frameworkControlInternalControl,
        array $internalControlTest,
    ) {
        foreach ($frameworks as $framework) {
            $record = FrameworkRecord::fromArray($framework);
            $this->frameworksBySlug[$record->slug] = $record;
        }

        foreach ($frameworkControls as $frameworkControl) {
            $framework = $this->frameworksBySlug[$frameworkControl['framework_slug']] ?? null;

            if (! $framework) {
                continue;
            }

            $record = FrameworkControlRecord::fromArray($frameworkControl, $framework);
            $this->frameworkControlsByKey[$this->frameworkControlKey($record->frameworkSlug, $record->code)] = $record;
        }

        foreach ($internalControls as $internalControl) {
            $record = ControlRecord::fromArray($internalControl);
            $this->controlsByVantaId[$record->vantaId] = $record;
            $this->controlsByExternalId[$record->externalId] = $record;
        }

        foreach ($tests as $test) {
            $record = TestRecord::fromArray($test);
            $this->testsByKey[$record->key] = $record;
        }

        $this->frameworkControlInternalControl = $frameworkControlInternalControl;
        $this->internalControlTest = $internalControlTest;
    }

    public static function fromPackageResources(?string $path = null): self
    {
        $path ??= dirname(__DIR__, 2).'/resources/frameworks/vanta/data';

        return new self(
            frameworks: self::requireDataFile($path.'/frameworks.php'),
            frameworkControls: self::requireDataFile($path.'/framework-controls.php'),
            internalControls: self::requireDataFile($path.'/internal-controls.php'),
            tests: self::requireDataFile($path.'/tests.php'),
            frameworkControlInternalControl: self::requireDataFile($path.'/framework-control-internal-control.php'),
            internalControlTest: self::requireDataFile($path.'/internal-control-test.php'),
        );
    }

    public function framework(string $slug): ?FrameworkRecord
    {
        return $this->frameworksBySlug[$slug] ?? null;
    }

    public function control(BackedEnum|string $control): ?ControlRecord
    {
        $identifier = $this->normalizeControlIdentifier($control);

        return $this->controlsByExternalId[$identifier]
            ?? $this->controlsByVantaId[$identifier]
            ?? null;
    }

    /**
     * @return array<int, ControlRecord>
     */
    public function controls(): array
    {
        return array_values($this->controlsByExternalId);
    }

    public function frameworkControl(string $frameworkSlug, string $code): ?FrameworkControlRecord
    {
        return $this->frameworkControlsByKey[$this->frameworkControlKey($frameworkSlug, $code)] ?? null;
    }

    /**
     * @return array<int, FrameworkControlRecord>
     */
    public function frameworkControlsForInternalControl(BackedEnum|string $control): array
    {
        $record = $this->control($control);

        if (! $record) {
            return [];
        }

        $frameworkControls = [];

        foreach ($this->frameworkControlInternalControl as $pivot) {
            if (($pivot['internal_control_external_id'] ?? null) !== $record->externalId) {
                continue;
            }

            $frameworkControl = $this->frameworkControl(
                (string) $pivot['framework_slug'],
                (string) $pivot['framework_control_code'],
            );

            if ($frameworkControl) {
                $frameworkControls[$frameworkControl->id()] = $frameworkControl;
            }
        }

        ksort($frameworkControls);

        return array_values($frameworkControls);
    }

    /**
     * @return array<int, TestRecord>
     */
    public function testsForInternalControl(BackedEnum|string $control): array
    {
        $record = $this->control($control);

        if (! $record) {
            return [];
        }

        $tests = [];

        foreach ($this->internalControlTest as $pivot) {
            if (($pivot['internal_control_vanta_id'] ?? null) !== $record->vantaId) {
                continue;
            }

            $testKey = $pivot['test_key'] ?? null;

            if (is_string($testKey) && isset($this->testsByKey[$testKey])) {
                $tests[$testKey] = $this->testsByKey[$testKey];
            }
        }

        ksort($tests);

        return array_values($tests);
    }

    private function normalizeControlIdentifier(BackedEnum|string $control): string
    {
        $identifier = $control instanceof BackedEnum ? (string) $control->value : $control;

        if (str_starts_with($identifier, 'VANTA:')) {
            return substr($identifier, strlen('VANTA:'));
        }

        return $identifier;
    }

    private function frameworkControlKey(string $frameworkSlug, string $code): string
    {
        return $frameworkSlug.'|'.$code;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function requireDataFile(string $path): array
    {
        $data = require $path;

        if (! is_array($data)) {
            throw new \RuntimeException("Expected Vanta data file to return an array: {$path}");
        }

        return $data;
    }
}
