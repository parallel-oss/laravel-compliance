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
- **Gaps** describe code paths that should have compliance-related behavior but do not yet. Use `ComplianceGap`, not `Evidence`, for missing work.
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

## Choosing Controls

Map code to what it demonstrably does. Then let the generated local seed pivots map that control to framework requirements and related tests.

Good:

```php
#[Evidence(
    controls: ComplianceControl::CustomerDataDeletedUponLeaving,
    summary: 'Deletes user profile data and related records during account closure.',
)]
```

Avoid:

```php
// Avoid this style unless there is a direct technical requirement enum.
#[Evidence(summary: 'This satisfies GDPR Article 17.')]
```

Use these common controls as starting points:

- Use `ComplianceControl::CustomerDataDeletedUponLeaving` for code that deletes customer data when customers leave the service.
- Use `ComplianceControl::DataEncryptionUtilized` for encryption at rest.
- Use `ComplianceControl::DataTransmissionEncrypted` for encryption in transit.
- Use `ComplianceControl::AccessControlProceduresEstablished`, `ProductionApplicationAccessRestricted`, and related access cases for authorization and least-privilege behavior.
- Use `ComplianceControl::RemoteAccessMfaEnforced`, `PasswordPolicyEnforced`, and `UniqueAccountAuthenticationEnforced` for authentication, password, and MFA behavior.
- Use `ComplianceControl::LogManagementUtilized`, `InfrastructurePerformanceMonitored`, and `IntrusionDetectionSystemUtilized` for logging, monitoring, and alerting behavior.
- Use `ComplianceControl::ChangeManagementProceduresEnforced`, `ConfigurationManagementSystemEstablished`, `NetworkAndSystemHardeningStandardsMaintained`, and `VulnerabilitiesScannedAndRemediated` for SDLC, configuration, hardening, and vulnerability remediation behavior.
- Use `ComplianceControl::ThirdPartyAgreementsEstablished` or `VendorManagementProgramEstablished` when code or workflows directly support vendor/security review evidence.

Do not use `ComplianceControl` for policy-only, HR-only, physical-office, board, insurance, meeting-minute, or pure audit-placeholder evidence. Those may exist in raw resources but are intentionally excluded from code-facing controls.

Use gaps for missing compliance work:

```php
use Parallel\Compliance\ComplianceGap;
use Parallel\Compliance\Controls\ComplianceControl;

#[ComplianceGap(
    summary: 'Account closure does not delete generated export files.',
    controls: ComplianceControl::CustomerDataDeletedUponLeaving,
    remediation: 'Delete object storage exports during account closure.',
    owner: 'platform',
)]
public function closeAccount(User $user): void
{
    // ...
}
```

## Commands

Generate a Markdown evidence report:

```bash
php artisan security:generate-report
```

Generate a Markdown report of known compliance gaps:

```bash
php artisan security:find-gaps
```

Publish packaged Cursor project skills into the current project:

```bash
php artisan laravel-compliance:publish-skills
```

This writes skills to `.cursor/skills/<skill-name>/SKILL.md` and preserves existing project skills unless `--force` is passed.

Useful report options:

```bash
php artisan security:generate-report \
    --path=app \
    --output=security-evidence-report.md
```

## Agent Rules

- Always use enums for controls and direct technical requirements.
- Prefer `ComplianceControl` for code evidence when the code maps to a curated engineering/security/privacy behavior.
- Use `ComplianceGap` to mark missing compliance work so it is visible without being counted as implemented evidence.
- Do not use code-facing controls for policy-only, HR-only, physical-office, board, insurance, meeting-minute, or pure audit-placeholder evidence.
- Let the generated local seed pivots map compliance controls to framework requirements.
- Use application-owned direct requirement enums only for exact technical requirements.
- Do not put raw GDPR/SOC 2 identifiers directly in application attributes.
- Add concise summaries that explain the actual behavior implemented by the code.
- Use `details` and `links` for audit context, tickets, pull requests, policies, or runbooks.
- After code edits, run `composer format`, `composer test`, `composer analyse`, and `composer audit`.

For source mapping details, see `references/mapping-sources.md`.
