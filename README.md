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

## How It Works

Application code is tagged with plain-English behavior controls:

```php
#[Evidence(
    controls: ComplianceControl::CustomerDataDeletedUponLeaving,
    summary: 'Deletes user profile data and related records during account closure.',
)]
```

The package then maps that behavior through prepackaged local data:

```text
CustomerDataDeletedUponLeaving
  -> internal source control: DCH-1
  -> framework controls: SOC2:C1.2, SOC2:CC6.5
  -> related monitoring tests, when available
```

Package users do not import remote data or generate enums before using the package. The raw source data has already been processed into local seed arrays under `resources/frameworks/vanta/data`:

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

The public `ComplianceControl` enum is intentionally curated. It includes engineering-relevant behaviors for access, encryption, logging, monitoring, SDLC, vulnerability management, privacy engineering, vendors, and related security operations. It excludes policy-only, HR-only, physical-office, board, insurance, meeting-minute, and pure audit-placeholder controls from code-facing evidence.

## LLM Agent Skills

This package publishes portable Agent Skills under `skills/` and advertises them through Composer metadata:

- `use-laravel-compliance`: how to annotate Laravel code with readable controls and produce reports.
- `map-compliance-evidence`: how to map code behavior to controls and framework references without overclaiming compliance.

Agents that support Composer-discovered skills can sync them from the package. Agents that read repository instruction files can use `AGENTS.md`.

## Usage

Prefer control evidence when the code demonstrates behavior that may support multiple frameworks:

```php
use Parallel\Compliance\Controls\ComplianceControl;
use Parallel\Compliance\Evidence;
use Parallel\Compliance\EvidenceStatus;

class AccountClosureService
{
    #[Evidence(
        controls: ComplianceControl::CustomerDataDeletedUponLeaving,
        summary: 'Deletes user profile data and related records during account closure.',
        status: EvidenceStatus::Implemented,
    )]
    public function deleteUserData(User $user): void
    {
        // ...
    }
}
```

Control metadata and framework mappings are loaded from prepackaged local seed arrays. The enum stays small and ergonomic; source IDs, titles, descriptions, domains, framework controls, and related monitoring tests are implementation details that the report expands automatically.

You may still use direct requirement enums when your application already owns a technical requirement catalog:

```php
use App\Compliance\Requirements\PasswordResetRequirement;
use Parallel\Compliance\Evidence;

#[Evidence(
    requirements: PasswordResetRequirement::TokensExpire,
    summary: 'Password reset uses signed, expiring tokens.',
    links: ['https://github.com/example/app/pull/123'],
)]
class ResetPasswordController
{
    #[Evidence(
        requirements: PasswordResetRequirement::TokensAreSingleUse,
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
