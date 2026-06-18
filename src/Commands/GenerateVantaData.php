<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;

class GenerateVantaData extends Command
{
    protected $signature = 'security:generate-vanta-data
        {--source= : Directory containing Vanta raw, controls, tests, control-tests, and test-entities resources}
        {--output= : Directory where generated seed PHP arrays should be written}
        {--control-enum-output= : Optional VantaControl enum file to regenerate from curated controls}';

    protected $description = 'Generates curated seedable Vanta compliance data arrays';

    /** @var array<int, string> */
    private const INCLUDED_DOMAINS = [
        'ASSET_MANAGEMENT',
        'BUSINESS_CONTINUITY_&_DISASTER_RECOVERY',
        'CHANGE_MANAGEMENT',
        'CONFIGURATION_MANAGEMENT',
        'CONTINUOUS_MONITORING',
        'CRYPTOGRAPHIC_PROTECTIONS',
        'DATA_CLASSIFICATION_&_HANDLING',
        'ENDPOINT_SECURITY',
        'IDENTIFICATION_&_AUTHENTICATION',
        'INCIDENT_RESPONSE',
        'INFORMATION_ASSURANCE',
        'MOBILE_DEVICE_MANAGEMENT',
        'NETWORK SECURITY',
        'SECURITY_OPERATIONS',
        'THIRD-PARTY_MANAGEMENT',
        'VULNERABILITY_&_PATCH_MANAGEMENT',
    ];

    /** @var array<int, string> */
    private const EXCLUDED_DOMAINS = [
        'COMPLIANCE',
        'HUMAN_RESOURCES_SECURITY',
        'PHYSICAL_&_ENVIRONMENTAL_SECURITY',
        'PROJECT_&_RESOURCE MANAGEMENT',
        'RISK_MANAGEMENT',
        'SECURITY_AWARENESS_&_TRAINING',
        'SECURITY_&_PRIVACY_GOVERNANCE',
    ];

    /** @var array<int, string> */
    private const ENGINEERING_KEYWORDS = [
        'access',
        'ai',
        'alert',
        'api',
        'application',
        'authentication',
        'authorization',
        'backup',
        'branch protection',
        'change',
        'code',
        'configuration',
        'cryptograph',
        'data',
        'database',
        'delete',
        'dependency',
        'encrypt',
        'firewall',
        'github',
        'incident',
        'infrastructure',
        'key',
        'log',
        'mfa',
        'monitor',
        'network',
        'password',
        'patch',
        'privacy',
        'production',
        'repository',
        'retention',
        'review',
        'secret',
        'security',
        'server',
        'subprocessor',
        'vendor',
        'vulnerab',
    ];

    /** @var array<int, string> */
    private const EXCLUDED_KEYWORDS = [
        'approved policy',
        'background check',
        'board',
        'code of conduct',
        'employee',
        'employment',
        'handbook',
        'insurance',
        'meeting',
        'office',
        'performance review',
        'physical',
        'policy approval',
        'visitor',
        'whistleblower',
    ];

    public function handle(): int
    {
        $sourcePath = rtrim($this->option('source') ?: $this->packagePath('resources/frameworks/vanta'), '/');
        $outputPath = rtrim($this->option('output') ?: $sourcePath.'/data', '/');

        if (! is_dir($sourcePath.'/raw')) {
            $this->error("Vanta raw directory not found at {$sourcePath}/raw.");

            return self::FAILURE;
        }

        $data = $this->buildData($sourcePath);
        $this->writeDataFiles($outputPath, $data);

        if ($this->option('control-enum-output')) {
            $this->writeVantaControlEnum((string) $this->option('control-enum-output'), $data['internal-controls']);
        }

        $this->info('Generated curated Vanta compliance data:');
        foreach ($data as $name => $rows) {
            $this->line("- {$name}: ".count($rows));
        }

        return self::SUCCESS;
    }

    private function packagePath(string $path = ''): string
    {
        $root = dirname(__DIR__, 2);

        return $path === '' ? $root : $root.'/'.$path;
    }

    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    private function buildData(string $sourcePath): array
    {
        $controlMetadata = $this->loadControlMetadata($sourcePath.'/controls/all.json');
        $curatedControlIds = $this->curatedControlIds($sourcePath.'/control-tests');
        $rawFrameworkData = $this->loadRawFrameworkData($sourcePath.'/raw');
        $rawControlsBySlug = $rawFrameworkData['rawControlsBySlug'];

        $internalControls = $this->buildInternalControls($controlMetadata, $curatedControlIds, $rawControlsBySlug);
        $internalControlIds = array_column($internalControls, 'vanta_id');
        $internalControlsByExternalId = $this->indexBy($internalControls, 'external_id');
        $internalControlIdsLookup = array_fill_keys($internalControlIds, true);

        $frameworkControlInternalControl = $this->curatedFrameworkControlPivots(
            $rawFrameworkData['frameworkControlInternalControl'],
            $internalControlsByExternalId,
        );

        $controlTests = $this->loadControlTests($sourcePath.'/control-tests', $internalControlIdsLookup);
        $testEntities = $this->loadTestEntities($sourcePath.'/test-entities');
        $referencedTestKeys = array_values(array_unique([
            ...array_column($controlTests, 'test_key'),
            ...array_keys($testEntities),
        ]));

        $tests = $this->buildTests($sourcePath.'/tests/all.json', $referencedTestKeys, $controlTests);
        $testKeys = array_fill_keys(array_column($tests, 'key'), true);
        $internalControlTest = array_values(array_filter(
            $controlTests,
            fn (array $pivot): bool => isset($testKeys[$pivot['test_key']]),
        ));

        $integrations = $this->buildIntegrations($tests);
        $integrationTest = $this->buildIntegrationTestPivots($tests);
        $testEntityRows = $this->buildTestEntityRows($testEntities, $testKeys);

        return [
            'frameworks' => $rawFrameworkData['frameworks'],
            'framework-controls' => $rawFrameworkData['frameworkControls'],
            'internal-controls' => $internalControls,
            'tests' => $tests,
            'integrations' => $integrations,
            'framework-control-internal-control' => $frameworkControlInternalControl,
            'internal-control-test' => $this->sortRows($internalControlTest, ['internal_control_vanta_id', 'test_key']),
            'integration-test' => $integrationTest,
            'test-entities' => $testEntityRows,
        ];
    }

    /**
     * @return array{bySlug: array<string, array<string, mixed>>, byExternalId: array<string, array<string, mixed>>}
     */
    private function loadControlMetadata(string $path): array
    {
        $payload = $this->readJson($path);
        $records = $payload['data'] ?? [];
        $bySlug = [];
        $byExternalId = [];

        foreach ($records as $record) {
            if (! is_array($record)) {
                continue;
            }

            if (! empty($record['id'])) {
                $bySlug[$record['id']] = $record;
            }

            if (! empty($record['externalId'])) {
                $byExternalId[$record['externalId']] = $record;
            }
        }

        return [
            'bySlug' => $bySlug,
            'byExternalId' => $byExternalId,
        ];
    }

    /**
     * @return array<string, true>
     */
    private function curatedControlIds(string $path): array
    {
        $ids = [];

        foreach ($this->jsonFiles($path) as $file) {
            $payload = $this->readJson($file);
            $ids[$payload['controlId'] ?? pathinfo($file, PATHINFO_FILENAME)] = true;
        }

        ksort($ids);

        return $ids;
    }

    /**
     * @return array{
     *     frameworks: array<int, array<string, mixed>>,
     *     frameworkControls: array<int, array<string, mixed>>,
     *     frameworkControlInternalControl: array<int, array<string, mixed>>,
     *     rawControlsBySlug: array<string, array<string, mixed>>
     * }
     */
    private function loadRawFrameworkData(string $path): array
    {
        $frameworks = [];
        $frameworkControls = [];
        $frameworkControlInternalControl = [];
        $rawControlsBySlug = [];

        foreach ($this->jsonFiles($path) as $file) {
            $frameworkSlug = pathinfo($file, PATHINFO_FILENAME);
            $relativeFile = 'resources/frameworks/vanta/raw/'.basename($file);
            $payload = $this->readJson($file);

            $frameworks[] = [
                'slug' => $frameworkSlug,
                'name' => $this->frameworkName($frameworkSlug),
                'description' => null,
                'source' => 'vanta',
                'raw_file' => $relativeFile,
            ];

            foreach (($payload['principles'] ?? []) as $principleIndex => $principle) {
                if (! is_array($principle)) {
                    continue;
                }

                foreach (($principle['sections'] ?? []) as $sectionIndex => $section) {
                    if (! is_array($section) || empty($section['id'])) {
                        continue;
                    }

                    $frameworkControlCode = $this->normalizeFrameworkControlCode((string) $section['id']);
                    $row = [
                        'framework_slug' => $frameworkSlug,
                        'code' => $frameworkControlCode,
                        'title' => $this->sectionTitle($section, $frameworkControlCode),
                        'description' => $this->nullableString($section['description'] ?? null),
                        'principle_id' => $this->nullableString($principle['id'] ?? null),
                        'principle_name' => $this->nullableString($principle['name'] ?? null),
                        'variants' => $this->strings($section['variants'] ?? []),
                        'source' => 'vanta',
                        'source_file' => $relativeFile,
                        'sort_order' => count($frameworkControls) + 1,
                    ];

                    if (array_key_exists('context', $section)) {
                        $row['context'] = $section['context'];
                    }

                    $frameworkControls[] = $row;

                    foreach (($section['controls'] ?? []) as $control) {
                        if (! is_array($control) || empty($control['externalId'])) {
                            continue;
                        }

                        if (! empty($control['id'])) {
                            $rawControlsBySlug[$control['id']] = [
                                'id' => $control['id'],
                                'externalId' => $control['externalId'],
                                'source' => 'Vanta',
                            ];
                        }

                        $frameworkControlInternalControl[] = [
                            'framework_slug' => $frameworkSlug,
                            'framework_control_code' => $frameworkControlCode,
                            'internal_control_external_id' => $control['externalId'],
                            'internal_control_vanta_id' => $control['id'] ?? null,
                            'variants' => $this->strings($control['variants'] ?? []),
                        ];
                    }
                }
            }
        }

        return [
            'frameworks' => $this->sortRows($frameworks, ['slug']),
            'frameworkControls' => $frameworkControls,
            'frameworkControlInternalControl' => $this->deduplicateRows($frameworkControlInternalControl, [
                'framework_slug',
                'framework_control_code',
                'internal_control_external_id',
            ]),
            'rawControlsBySlug' => $rawControlsBySlug,
        ];
    }

    /**
     * @param  array{bySlug: array<string, array<string, mixed>>, byExternalId: array<string, array<string, mixed>>}  $controlMetadata
     * @param  array<string, true>  $curatedControlIds
     * @param  array<string, array<string, mixed>>  $rawControlsBySlug
     * @return array<int, array<string, mixed>>
     */
    private function buildInternalControls(array $controlMetadata, array $curatedControlIds, array $rawControlsBySlug): array
    {
        $controls = [];

        foreach ($controlMetadata['bySlug'] as $slug => $record) {
            if (! isset($curatedControlIds[$slug]) && ! $this->isEngineeringRelevantControl($record)) {
                continue;
            }

            $controls[] = $this->internalControlRecord($record);
        }

        foreach ($curatedControlIds as $slug => $_) {
            if (isset($controlMetadata['bySlug'][$slug])) {
                continue;
            }

            $rawRecord = $rawControlsBySlug[$slug] ?? [
                'id' => $slug,
                'externalId' => null,
                'source' => 'Vanta',
            ];

            $controls[] = $this->internalControlRecord($rawRecord);
        }

        return $this->sortRows($this->deduplicateRows($controls, ['vanta_id']), ['external_id', 'vanta_id']);
    }

    /**
     * @param  array<string, mixed>  $record
     * @return array<string, mixed>
     */
    private function internalControlRecord(array $record): array
    {
        $slug = (string) ($record['id'] ?? '');
        $externalId = $this->nullableString($record['externalId'] ?? null);

        return [
            'vanta_id' => $slug,
            'external_id' => $externalId,
            'name' => $this->nullableString($record['name'] ?? null) ?? $this->titleFromSlug($slug ?: ($externalId ?? 'unknown-control')),
            'description' => $this->nullableString($record['description'] ?? null),
            'domains' => $this->strings($record['domains'] ?? []),
            'source' => $this->nullableString($record['source'] ?? null) ?? 'Vanta',
        ];
    }

    /**
     * @param  array<string, mixed>  $record
     */
    private function isEngineeringRelevantControl(array $record): bool
    {
        $domains = $this->strings($record['domains'] ?? []);
        $text = strtolower(implode(' ', [
            $record['id'] ?? '',
            $record['externalId'] ?? '',
            $record['name'] ?? '',
            $record['description'] ?? '',
            ...$domains,
        ]));

        foreach (self::EXCLUDED_KEYWORDS as $keyword) {
            if (str_contains($text, $keyword)) {
                return false;
            }
        }

        if (array_intersect($domains, self::INCLUDED_DOMAINS) !== []) {
            return true;
        }

        if (array_intersect($domains, self::EXCLUDED_DOMAINS) !== []) {
            return str_contains($text, 'ai ') || str_contains($text, 'artificial intelligence');
        }

        foreach (self::ENGINEERING_KEYWORDS as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $test
     */
    private function isEngineeringRelevantTest(array $test): bool
    {
        if (($test['category'] ?? null) === 'Policies') {
            return false;
        }

        $text = strtolower(implode(' ', [
            $test['id'] ?? '',
            $test['name'] ?? '',
            $test['description'] ?? '',
            $test['failureDescription'] ?? '',
            $test['remediationDescription'] ?? '',
            $test['category'] ?? '',
            ...$this->strings($test['integrations'] ?? []),
        ]));

        foreach (self::EXCLUDED_KEYWORDS as $keyword) {
            if (str_contains($text, $keyword)) {
                return false;
            }
        }

        foreach (self::ENGINEERING_KEYWORDS as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rawPivots
     * @param  array<string, array<string, mixed>>  $internalControlsByExternalId
     * @return array<int, array<string, mixed>>
     */
    private function curatedFrameworkControlPivots(array $rawPivots, array $internalControlsByExternalId): array
    {
        $rows = [];

        foreach ($rawPivots as $pivot) {
            $externalId = $pivot['internal_control_external_id'];

            if (! isset($internalControlsByExternalId[$externalId])) {
                continue;
            }

            $rows[] = [
                'framework_slug' => $pivot['framework_slug'],
                'framework_control_code' => $pivot['framework_control_code'],
                'internal_control_external_id' => $externalId,
                'internal_control_vanta_id' => $internalControlsByExternalId[$externalId]['vanta_id'],
                'variants' => $pivot['variants'],
            ];
        }

        return $this->sortRows($this->deduplicateRows($rows, [
            'framework_slug',
            'framework_control_code',
            'internal_control_external_id',
        ]), ['framework_slug', 'framework_control_code', 'internal_control_external_id']);
    }

    /**
     * @param  array<string, true>  $internalControlIds
     * @return array<int, array<string, mixed>>
     */
    private function loadControlTests(string $path, array $internalControlIds): array
    {
        $rows = [];

        foreach ($this->jsonFiles($path) as $file) {
            $payload = $this->readJson($file);
            $controlId = $payload['controlId'] ?? pathinfo($file, PATHINFO_FILENAME);

            if (! isset($internalControlIds[$controlId])) {
                continue;
            }

            foreach (($payload['data'] ?? []) as $test) {
                if (! is_array($test) || empty($test['id'])) {
                    continue;
                }

                if (! $this->isEngineeringRelevantTest($test)) {
                    continue;
                }

                $rows[] = [
                    'internal_control_vanta_id' => $controlId,
                    'test_key' => $test['id'],
                    'test' => $test,
                ];
            }
        }

        return $this->deduplicateRows($rows, ['internal_control_vanta_id', 'test_key']);
    }

    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    private function loadTestEntities(string $path): array
    {
        $entities = [];

        foreach ($this->jsonFiles($path) as $file) {
            $payload = $this->readJson($file);
            $testKey = $payload['testId'] ?? pathinfo($file, PATHINFO_FILENAME);

            foreach (($payload['data'] ?? []) as $entity) {
                if (is_array($entity)) {
                    $entities[$testKey][] = $entity;
                }
            }
        }

        ksort($entities);

        return $entities;
    }

    /**
     * @param  array<int, string>  $referencedTestKeys
     * @param  array<int, array<string, mixed>>  $controlTests
     * @return array<int, array<string, mixed>>
     */
    private function buildTests(string $path, array $referencedTestKeys, array $controlTests): array
    {
        $payload = $this->readJson($path);
        $testsByKey = [];

        foreach (($payload['data'] ?? []) as $test) {
            if (is_array($test) && ! empty($test['id'])) {
                $testsByKey[$test['id']] = $test;
            }
        }

        foreach ($controlTests as $pivot) {
            $testsByKey[$pivot['test_key']] ??= $pivot['test'];
        }

        $rows = [];
        foreach ($referencedTestKeys as $key) {
            if (! isset($testsByKey[$key])) {
                continue;
            }

            $test = $testsByKey[$key];
            $rows[] = [
                'vanta_test_id' => $key,
                'key' => $key,
                'title' => $this->nullableString($test['name'] ?? null) ?? $this->titleFromSlug($key),
                'description' => $this->nullableString($test['description'] ?? null),
                'failure_description' => $this->nullableString($test['failureDescription'] ?? null),
                'remediation_instructions' => $this->nullableString($test['remediationDescription'] ?? null),
                'category' => $this->nullableString($test['category'] ?? null),
                'status' => $this->nullableString($test['status'] ?? null),
                'integrations' => $this->integrationSlugs($test['integrations'] ?? []),
            ];
        }

        return $this->sortRows($this->deduplicateRows($rows, ['key']), ['key']);
    }

    /**
     * @param  array<int, array<string, mixed>>  $tests
     * @return array<int, array<string, string>>
     */
    private function buildIntegrations(array $tests): array
    {
        $integrations = [];

        foreach ($tests as $test) {
            foreach ($test['integrations'] as $slug) {
                $integrations[$slug] = [
                    'slug' => $slug,
                    'name' => $this->titleFromSlug($slug),
                ];
            }
        }

        ksort($integrations);

        return array_values($integrations);
    }

    /**
     * @param  array<int, array<string, mixed>>  $tests
     * @return array<int, array<string, string>>
     */
    private function buildIntegrationTestPivots(array $tests): array
    {
        $rows = [];

        foreach ($tests as $test) {
            foreach ($test['integrations'] as $slug) {
                $rows[] = [
                    'integration_slug' => $slug,
                    'test_key' => $test['key'],
                ];
            }
        }

        return $this->sortRows($this->deduplicateRows($rows, ['integration_slug', 'test_key']), ['integration_slug', 'test_key']);
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $testEntities
     * @param  array<string, true>  $testKeys
     * @return array<int, array<string, mixed>>
     */
    private function buildTestEntityRows(array $testEntities, array $testKeys): array
    {
        $rows = [];

        foreach ($testEntities as $testKey => $entities) {
            if (! isset($testKeys[$testKey])) {
                continue;
            }

            foreach ($entities as $entity) {
                $rows[] = [
                    'test_key' => $testKey,
                    'entity_id' => $this->nullableString($entity['id'] ?? null),
                    'entity_type' => $this->nullableString($entity['responseType'] ?? null),
                    'display_name' => $this->nullableString($entity['displayName'] ?? null),
                    'status' => $this->nullableString($entity['entityStatus'] ?? null),
                    'last_updated_at' => $this->nullableString($entity['lastUpdatedDate'] ?? null),
                ];
            }
        }

        return $this->sortRows($this->deduplicateRows($rows, ['test_key', 'entity_id']), ['test_key', 'entity_id']);
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $data
     */
    private function writeDataFiles(string $outputPath, array $data): void
    {
        if (! is_dir($outputPath)) {
            mkdir($outputPath, 0755, true);
        }

        foreach ($data as $name => $rows) {
            file_put_contents($outputPath.'/'.$name.'.php', "<?php\n\nreturn ".$this->exportValue($rows).";\n");
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $controls
     */
    private function writeVantaControlEnum(string $path, array $controls): void
    {
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $cases = [];
        foreach ($controls as $control) {
            $externalId = (string) $control['external_id'];
            $caseName = $this->enumCaseName($externalId);
            $description = (string) ($control['name'] ?? $externalId);

            if (! empty($control['description'])) {
                $description .= "\n\n".$control['description'];
            }

            $cases[] = [
                'name' => $caseName,
                'value' => 'VANTA:'.$externalId,
                'comment' => $description,
            ];
        }

        $contents = "<?php\n\n";
        $contents .= "namespace Parallel\\Compliance\\Controls;\n\n";
        $contents .= "use Parallel\\Compliance\\Data\\ControlRecord;\n";
        $contents .= "use Parallel\\Compliance\\Data\\VantaComplianceData;\n\n";
        $contents .= "/**\n";
        $contents .= " * @generated by security:generate-vanta-data\n";
        $contents .= " */\n";
        $contents .= "enum VantaControl: string implements Control\n";
        $contents .= "{\n";

        foreach ($cases as $case) {
            $contents .= $this->phpDoc($case['comment'], 1);
            $contents .= "    case {$case['name']} = '{$case['value']}';\n\n";
        }

        $contents .= <<<'PHP'
    public function id(): string
    {
        return $this->value;
    }

    public function source(): string
    {
        return $this->record()->source;
    }

    public function externalId(): string
    {
        return str_replace('VANTA:', '', $this->value);
    }

    public function slug(): string
    {
        return $this->record()->vantaId;
    }

    public function title(): string
    {
        return $this->record()->name;
    }

    public function description(): ?string
    {
        return $this->record()->description;
    }

    public function domains(): array
    {
        return $this->record()->domains;
    }

    private function record(): ControlRecord
    {
        $record = VantaComplianceData::fromPackageResources()->control($this);

        if (! $record) {
            throw new \RuntimeException("Missing Vanta control data for {$this->value}.");
        }

        return $record;
    }
}
PHP;

        file_put_contents($path, $contents."\n");
    }

    /**
     * @return array<string, mixed>
     */
    private function readJson(string $path): array
    {
        $contents = file_get_contents($path);
        $decoded = json_decode($contents === false ? '' : $contents, true);

        if (! is_array($decoded)) {
            throw new \RuntimeException("Unable to decode JSON at {$path}.");
        }

        return $decoded;
    }

    /**
     * @return array<int, string>
     */
    private function jsonFiles(string $path): array
    {
        $files = glob($path.'/*.json') ?: [];
        sort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @return array<string, array<string, mixed>>
     */
    private function indexBy(array $rows, string $key): array
    {
        $indexed = [];

        foreach ($rows as $row) {
            if (! empty($row[$key])) {
                $indexed[$row[$key]] = $row;
            }
        }

        return $indexed;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @param  array<int, string>  $keys
     * @return array<int, array<string, mixed>>
     */
    private function sortRows(array $rows, array $keys): array
    {
        usort($rows, function (array $left, array $right) use ($keys): int {
            foreach ($keys as $key) {
                $comparison = strcmp((string) ($left[$key] ?? ''), (string) ($right[$key] ?? ''));

                if ($comparison !== 0) {
                    return $comparison;
                }
            }

            return 0;
        });

        return $rows;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @param  array<int, string>  $keys
     * @return array<int, array<string, mixed>>
     */
    private function deduplicateRows(array $rows, array $keys): array
    {
        $deduplicated = [];
        $seen = [];

        foreach ($rows as $row) {
            $fingerprint = implode('|', array_map(
                fn (string $key): string => (string) ($row[$key] ?? ''),
                $keys,
            ));

            if (isset($seen[$fingerprint])) {
                continue;
            }

            $seen[$fingerprint] = true;
            $deduplicated[] = $row;
        }

        return $deduplicated;
    }

    /**
     * @return array<int, string>
     */
    private function strings(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter(
            array_map(fn (mixed $item): string => is_scalar($item) ? (string) $item : '', $value),
            fn (string $item): bool => $item !== '',
        ));
    }

    /**
     * @return array<int, string>
     */
    private function integrationSlugs(mixed $integrations): array
    {
        if (! is_array($integrations)) {
            return [];
        }

        $slugs = [];
        foreach ($integrations as $integration) {
            if (is_string($integration)) {
                $slugs[] = $integration;

                continue;
            }

            if (is_array($integration) && ! empty($integration['id'])) {
                $slugs[] = (string) $integration['id'];
            }
        }

        $slugs = array_values(array_unique(array_filter($slugs)));
        sort($slugs, SORT_NATURAL);

        return $slugs;
    }

    private function nullableString(mixed $value): ?string
    {
        if (! is_scalar($value)) {
            return null;
        }

        $string = trim((string) $value);

        return $string === '' ? null : $string;
    }

    /**
     * @param  array<string, mixed>  $section
     */
    private function sectionTitle(array $section, string $fallback): string
    {
        $name = $this->nullableString($section['name'] ?? null);

        if ($name !== null) {
            return $name;
        }

        $description = $this->nullableString($section['description'] ?? null);

        if ($description !== null && strlen($description) <= 120) {
            return $description;
        }

        return $fallback;
    }

    private function normalizeFrameworkControlCode(string $code): string
    {
        $code = trim($code);

        if (preg_match('/^[A-Z]{1,4}\s+\d/', $code) === 1) {
            return preg_replace('/\s+/', '', $code) ?: $code;
        }

        return $code;
    }

    private function frameworkName(string $slug): string
    {
        return match ($slug) {
            'aiact' => 'EU AI Act',
            'ccpa' => 'CCPA',
            'cmmc2' => 'CMMC 2.0',
            'dora' => 'DORA',
            'fedramp' => 'FedRAMP',
            'fedRAMPr5' => 'FedRAMP Rev. 5',
            'gdpr' => 'GDPR',
            'hipaa' => 'HIPAA',
            'iso27001' => 'ISO 27001',
            'iso27701' => 'ISO 27701',
            'iso27701_2025' => 'ISO 27701:2025',
            'iso9001' => 'ISO 9001',
            'msftSSPA' => 'Microsoft SSPA',
            'nist53' => 'NIST SP 800-53',
            'pciDss4' => 'PCI DSS 4.0',
            'soc2' => 'SOC 2',
            default => $this->titleFromSlug($slug),
        };
    }

    private function titleFromSlug(string $slug): string
    {
        $slug = preg_replace('/(?<!^)([A-Z])/', ' $1', $slug) ?: $slug;
        $slug = str_replace(['-', '_'], ' ', $slug);

        return ucwords(trim($slug));
    }

    private function enumCaseName(string $externalId): string
    {
        $name = preg_replace('/[^A-Za-z0-9]+/', '_', $externalId) ?: $externalId;

        if (preg_match('/^[A-Za-z]/', $name) !== 1) {
            $name = 'ID_'.$name;
        }

        return strtoupper($name);
    }

    private function phpDoc(string $comment, int $level = 0): string
    {
        $indent = str_repeat('    ', $level);
        $lines = preg_split('/\R/', trim($comment)) ?: [];
        $doc = $indent."/**\n";

        foreach ($lines as $line) {
            $line = rtrim($line);
            $doc .= $line === ''
                ? $indent." *\n"
                : $indent.' * '.str_replace('*/', '* /', $line)."\n";
        }

        return $doc.$indent." */\n";
    }

    private function exportValue(mixed $value, int $level = 0): string
    {
        if ($value === null) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (! is_array($value)) {
            return var_export($value, true);
        }

        if ($value === []) {
            return '[]';
        }

        $indent = str_repeat('    ', $level);
        $childIndent = str_repeat('    ', $level + 1);
        $lines = ['['];
        $isList = array_is_list($value);

        foreach ($value as $key => $childValue) {
            $prefix = $isList ? '' : var_export($key, true).' => ';
            $lines[] = $childIndent.$prefix.$this->exportValue($childValue, $level + 1).',';
        }

        $lines[] = $indent.']';

        return implode("\n", $lines);
    }
}
