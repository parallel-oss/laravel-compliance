---
name: use-laravel-compliance
description: Use the parallel-oss/laravel-compliance package to annotate Laravel code with curated enum-backed evidence, generate seedable Vanta data, import OWASP standards, generate requirement enums, and produce evidence reports.
license: MIT
compatibility: PHP 8.4+, Laravel 12+, Composer package parallel-oss/laravel-compliance
---

# Use Laravel Compliance

Use this skill when a user wants to add, review, or generate compliance evidence using `parallel-oss/laravel-compliance`.

## Mental Model

This package collects evidence. It does not prove compliance by itself.

- **Controls** describe what application code does, such as deleting customer data or enforcing access control. `VantaControl` is generated from curated engineering-relevant seed data.
- **Framework requirements** describe external references such as GDPR articles or SOC 2 Trust Services Criteria sections. Reports derive these from generated Vanta seed pivots, not hand-written mapping classes.
- **Generated requirements** are generated enums for technical standards such as OWASP ASVS or WSTG.
- **Reports** connect code evidence to controls, generated requirements, framework mappings, and related Vanta monitoring tests.

## Choosing Attribute Inputs

Prefer controls for broad compliance evidence:

```php
use Parallel\Compliance\Controls\VantaControl;
use Parallel\Compliance\Evidence;

#[Evidence(
    controls: VantaControl::DCH_1,
    summary: 'Deletes user profile data and related records during account closure.',
)]
public function deleteUserData(User $user): void
{
    // ...
}
```

Use direct requirements for specific technical requirements:

```php
use App\Enums\Compliance\OwaspAsvs500Requirements;
use Parallel\Compliance\Evidence;

#[Evidence(
    requirements: OwaspAsvs500Requirements::V2_1_1,
    summary: 'Password reset uses signed, expiring tokens.',
)]
public function resetPassword(): void
{
    // ...
}
```

You may combine both when a code path is both a control objective and a technical requirement.

## Commands

Import OWASP standards:

```bash
php artisan security:import-asvs
php artisan security:import-wstg
```

Generate app-local requirement enums:

```bash
php artisan security:generate-enums
```

Regenerate curated Vanta seed arrays and the package `VantaControl` enum when maintaining this package:

```bash
php vendor/bin/testbench security:generate-vanta-data \
    --control-enum-output=src/Controls/VantaControl.php
```

Generate a Markdown evidence report:

```bash
php artisan security:generate-report
```

Useful report options:

```bash
php artisan security:generate-report \
    --path=app \
    --standard=storage/app/compliance/standards/*.json \
    --output=security-evidence-report.md
```

## Agent Rules

- Always use enums for controls, framework requirements, and generated requirements.
- Prefer `VantaControl` for code evidence when the code maps to a curated engineering/security/privacy control.
- Do not use code-facing controls for policy-only, HR-only, physical-office, board, insurance, meeting-minute, or pure audit-placeholder evidence.
- Let `VantaComplianceData` and the generated seed pivots map Vanta controls to framework requirements.
- Use generated OWASP ASVS/WSTG requirement enums directly for exact technical requirements.
- Do not put raw GDPR/SOC 2 identifiers directly in application attributes.
- Add concise summaries that explain the actual behavior implemented by the code.
- Use `details` and `links` for audit context, tickets, pull requests, policies, or runbooks.
- After code edits, run `composer format`, `composer test`, `composer analyse`, and `composer audit`.
