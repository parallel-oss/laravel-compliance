# Laravel Compliance

[![Latest Version on Packagist](https://img.shields.io/packagist/v/parallel-oss/laravel-compliance.svg?style=flat-square)](https://packagist.org/packages/parallel-oss/laravel-compliance)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/parallel-oss/laravel-compliance/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/parallel-oss/laravel-compliance/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/parallel-oss/laravel-compliance/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/parallel-oss/laravel-compliance/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/parallel-oss/laravel-compliance.svg?style=flat-square)](https://packagist.org/packages/parallel-oss/laravel-compliance)

Laravel Compliance lets you map code-level evidence to curated, enum-backed controls and generated technical requirements. It does not claim that an annotation proves compliance; it gives teams a typed, reviewable way to connect implementation evidence to framework requirements, monitoring tests, and audit-friendly reports.

## Installation

You can install the package via composer:

```bash
composer require parallel-oss/laravel-compliance
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-compliance-config"
```

## Import Standards

Import normalized requirement JSON into `storage/app/compliance/standards`:

```bash
php artisan security:import-asvs
php artisan security:import-wstg
```

ASVS defaults to the stable OWASP ASVS 5.0.0 JSON release. WSTG defaults to OWASP's current checklist JSON. You can override either source:

```bash
php artisan security:import-asvs \
    --url="https://example.com/asvs.json" \
    --source-version="5.0.1" \
    --output="storage/app/compliance/standards/asvs.json"
```

## Generate OWASP Enums

Generate app-local backed enums for imported OWASP ASVS/WSTG requirements:

```bash
php artisan security:generate-enums
```

By default, enums are written to `App\Enums\Compliance`. Each generated enum implements `Parallel\Compliance\Recommendations\Recommendation`.

## Generate Vanta Data

This package ships raw Vanta framework resources and curated monitoring artifacts under `resources/frameworks/vanta`. Package maintainers can regenerate deterministic seed arrays and the curated package `VantaControl` enum from those resources:

```bash
php vendor/bin/testbench security:generate-vanta-data \
    --control-enum-output=src/Controls/VantaControl.php
```

Generated seed arrays are written to `resources/frameworks/vanta/data`:

- `frameworks.php`
- `framework-controls.php`
- `internal-controls.php`
- `tests.php`
- `integrations.php`
- `framework-control-internal-control.php`
- `internal-control-test.php`
- `integration-test.php`
- `test-entities.php`

These files are plain PHP arrays so downstream applications can seed their own database:

```php
$frameworks = require base_path('vendor/parallel-oss/laravel-compliance/resources/frameworks/vanta/data/frameworks.php');
```

The generated `VantaControl` enum is intentionally curated. It includes engineering-relevant controls for access, encryption, logging, monitoring, SDLC, vulnerability management, privacy engineering, vendors, and related security operations. It excludes policy-only, HR-only, physical-office, board, insurance, meeting-minute, and pure audit-placeholder controls from code-facing evidence.

## LLM Agent Skills

This package publishes portable Agent Skills under `skills/` and advertises them through Composer metadata:

- `use-laravel-compliance`: how to annotate Laravel code, import standards, generate enums, and produce reports.
- `map-compliance-evidence`: how to map code behavior to controls and framework references without overclaiming compliance.

Agents that support Composer-discovered skills can sync them from the package. Agents that read repository instruction files can use `AGENTS.md`.

## Usage

Prefer control evidence when the code demonstrates behavior that may support multiple frameworks:

```php
use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Evidence;
use Parallel\Compliance\EvidenceStatus;

class AccountClosureService
{
    #[Evidence(
        controls: VantaControl::DCH_1,
        summary: 'Deletes user profile data and related records during account closure.',
        status: EvidenceStatus::Implemented,
    )]
    public function deleteUserData(User $user): void
    {
        // ...
    }
}
```

Control metadata and framework mappings are generated from the Vanta seed arrays and loaded through `Parallel\Compliance\Data\VantaComplianceData`. The enum stays small and ergonomic; titles, descriptions, domains, framework controls, and related monitoring tests come from the generated data layer:

```php
use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Data\VantaComplianceData;

$data = VantaComplianceData::fromPackageResources();

$control = $data->control(VantaControl::DCH_1);
$frameworkControls = $data->frameworkControlsForInternalControl(VantaControl::DCH_1);
$tests = $data->testsForInternalControl(VantaControl::DCH_1);
```

Use direct requirements when the code maps to a technical requirement such as ASVS or WSTG:

```php
use App\Enums\Compliance\OwaspAsvs500Requirements;
use App\Enums\Compliance\OwaspWstgLatestRequirements;
use Parallel\Compliance\Evidence;

#[Evidence(
    requirements: [
        OwaspAsvs500Requirements::V2_1_1,
        OwaspWstgLatestRequirements::WSTG_ATHN_01,
    ],
    summary: 'Password reset uses signed, expiring tokens.',
    links: ['https://github.com/example/app/pull/123'],
)]
class ResetPasswordController
{
    #[Evidence(
        requirements: OwaspAsvs500Requirements::V2_1_2,
        summary: 'Password reset tokens are single-use.',
    )]
    public function __invoke(): void
    {
        // ...
    }
}
```

The legacy `Parallel\Compliance\Compliance` attribute remains available as an alias, but new code should use `Evidence`.

## Generate Reports

Generate a Markdown evidence report:

```bash
php artisan security:generate-report
```

Useful options:

```bash
php artisan security:generate-report \
    --path=app \
    --standard=storage/app/compliance/standards/*.json \
    --output=security-evidence-report.md
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Emaad Ali](https://github.com/emaadali)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
