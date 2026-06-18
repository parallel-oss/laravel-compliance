# Laravel Compliance

[![Latest Version on Packagist](https://img.shields.io/packagist/v/parallel-oss/laravel-compliance.svg?style=flat-square)](https://packagist.org/packages/parallel-oss/laravel-compliance)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/parallel-oss/laravel-compliance/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/parallel-oss/laravel-compliance/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/parallel-oss/laravel-compliance/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/parallel-oss/laravel-compliance/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/parallel-oss/laravel-compliance.svg?style=flat-square)](https://packagist.org/packages/parallel-oss/laravel-compliance)

Laravel Compliance lets you map code-level evidence to security requirements such as OWASP ASVS and WSTG. It does not claim that an annotation proves compliance; it gives teams a typed, reviewable way to connect implementation evidence to standards and generate audit-friendly reports.

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

## Generate Enums

Generate backed enums for IDE autocomplete and type safety:

```bash
php artisan security:generate-enums
```

By default, enums are written to `App\Enums\Compliance`. Each generated enum implements `Parallel\Compliance\Recommendations\Recommendation`.

## Usage

Prefer capability evidence when the code demonstrates what the system does and that evidence may support multiple frameworks:

```php
use Parallel\Compliance\Capabilities\CommonCapability;
use Parallel\Compliance\Evidence;
use Parallel\Compliance\EvidenceStatus;

class AccountClosureService
{
    #[Evidence(
        capabilities: CommonCapability::UserDataErasure,
        summary: 'Deletes user profile data and related records during account closure.',
        status: EvidenceStatus::Implemented,
    )]
    public function deleteUserData(User $user): void
    {
        // ...
    }
}
```

Capability mappings are enum-backed in `config/compliance.php`:

```php
use Parallel\Compliance\Capabilities\CommonCapability;
use Parallel\Compliance\Frameworks\GdprRequirement;
use Parallel\Compliance\Frameworks\Soc2TrustServicesCriteria;

return [
    'capability_mappings' => [
        CommonCapability::UserDataErasure->value => [
            GdprRequirement::Article17,
            Soc2TrustServicesCriteria::P4,
            Soc2TrustServicesCriteria::P5,
        ],
    ],
];
```

Use direct controls when the code maps to a technical requirement such as ASVS or WSTG:

```php
use App\Enums\Compliance\OwaspAsvs500Requirements;
use App\Enums\Compliance\OwaspWstgLatestRequirements;
use Parallel\Compliance\Evidence;

#[Evidence(
    controls: [
        OwaspAsvs500Requirements::V2_1_1,
        OwaspWstgLatestRequirements::WSTG_ATHN_01,
    ],
    summary: 'Password reset uses signed, expiring tokens.',
    links: ['https://github.com/example/app/pull/123'],
)]
class ResetPasswordController
{
    #[Evidence(
        controls: OwaspAsvs500Requirements::V2_1_2,
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
