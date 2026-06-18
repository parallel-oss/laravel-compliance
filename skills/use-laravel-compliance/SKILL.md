---
name: use-laravel-compliance
description: Use the parallel-oss/laravel-compliance package to annotate Laravel code with readable enum-backed controls and produce evidence reports from prepackaged local data.
license: MIT
compatibility: PHP 8.4+, Laravel 12+, Composer package parallel-oss/laravel-compliance
---

# Use Laravel Compliance

Use this skill when a user wants to add, review, or generate compliance evidence using `parallel-oss/laravel-compliance`.

## Mental Model

This package collects evidence. It does not prove compliance by itself.

- **Controls** describe what application code does, such as deleting customer data or enforcing access control. `ComplianceControl` is generated from curated local seed data.
- **Framework requirements** describe external references such as GDPR articles or SOC 2 Trust Services Criteria sections. Reports derive these from generated local seed pivots, not hand-written mapping classes.
- **Direct requirements** are optional application-owned enums for exact technical requirements.
- **Reports** connect code evidence to controls, framework mappings, and related monitoring tests.

## Choosing Attribute Inputs

Prefer controls for broad compliance evidence:

```php
use Parallel\Compliance\Controls\ComplianceControl;
use Parallel\Compliance\Evidence;

#[Evidence(
    controls: ComplianceControl::CustomerDataDeletedUponLeaving,
    summary: 'Deletes user profile data and related records during account closure.',
)]
public function deleteUserData(User $user): void
{
    // ...
}
```

Use direct requirements for specific technical requirements:

```php
use App\Compliance\Requirements\PasswordResetRequirement;
use Parallel\Compliance\Evidence;

#[Evidence(
    requirements: PasswordResetRequirement::TokensExpire,
    summary: 'Password reset uses signed, expiring tokens.',
)]
public function resetPassword(): void
{
    // ...
}
```

You may combine both when a code path is both a control objective and a technical requirement.

## Commands

Generate a Markdown evidence report:

```bash
php artisan security:generate-report
```

Useful report options:

```bash
php artisan security:generate-report \
    --path=app \
    --output=security-evidence-report.md
```

## Agent Rules

- Always use enums for controls and direct technical requirements.
- Prefer `ComplianceControl` for code evidence when the code maps to a curated engineering/security/privacy behavior.
- Do not use code-facing controls for policy-only, HR-only, physical-office, board, insurance, meeting-minute, or pure audit-placeholder evidence.
- Let the generated local seed pivots map compliance controls to framework requirements.
- Use application-owned direct requirement enums only for exact technical requirements.
- Do not put raw GDPR/SOC 2 identifiers directly in application attributes.
- Add concise summaries that explain the actual behavior implemented by the code.
- Use `details` and `links` for audit context, tickets, pull requests, policies, or runbooks.
- After code edits, run `composer format`, `composer test`, `composer analyse`, and `composer audit`.
