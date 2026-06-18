---
name: map-compliance-evidence
description: Map application behavior to curated enum-backed Laravel Compliance controls and generated technical requirements without overclaiming compliance.
license: MIT
compatibility: PHP 8.4+, Laravel 12+, Composer package parallel-oss/laravel-compliance
---

# Map Compliance Evidence

Use this skill when deciding which `ComplianceControl` enum cases or direct requirement enums apply to Laravel code.

## Mapping Principle

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
// Avoid this style unless there is a direct generated technical control enum.
#[Evidence(summary: 'This satisfies GDPR Article 17.')]
```

Use a gap marker when the behavior is missing:

```php
#[ComplianceGap(
    summary: 'Account closure does not delete generated export files.',
    controls: ComplianceControl::CustomerDataDeletedUponLeaving,
)]
```

## Control Guidance

- Use `ComplianceControl::CustomerDataDeletedUponLeaving` for code that deletes customer data when customers leave the service.
- Use `ComplianceControl::DataEncryptionUtilized` for encryption at rest.
- Use `ComplianceControl::DataTransmissionEncrypted` for encryption in transit.
- Use `ComplianceControl::AccessControlProceduresEstablished`, `ProductionApplicationAccessRestricted`, and related access cases for authorization and least-privilege behavior.
- Use `ComplianceControl::RemoteAccessMfaEnforced`, `PasswordPolicyEnforced`, and `UniqueAccountAuthenticationEnforced` for authentication, password, and MFA behavior.
- Use `ComplianceControl::LogManagementUtilized`, `InfrastructurePerformanceMonitored`, and `IntrusionDetectionSystemUtilized` for logging, monitoring, and alerting behavior.
- Use `ComplianceControl::ChangeManagementProceduresEnforced`, `ConfigurationManagementSystemEstablished`, `NetworkAndSystemHardeningStandardsMaintained`, and `VulnerabilitiesScannedAndRemediated` for SDLC, configuration, hardening, and vulnerability remediation behavior.
- Use `ComplianceControl::ThirdPartyAgreementsEstablished` or `VendorManagementProgramEstablished` when code or workflows directly support vendor/security review evidence.

Do not use `ComplianceControl` for policy-only, HR-only, physical-office, board, insurance, meeting-minute, or pure audit-placeholder evidence. Those may exist in raw resources but are intentionally excluded from code-facing controls.

## Framework Boundaries

- GDPR and SOC 2 mappings come from generated framework-control/internal-control pivots. They are references, not legal advice or proof of compliance.
- SOC 2 audit evidence normally also needs policies, risk assessments, approvals, logs, tickets, and operating evidence.
- OWASP direct requirements should come from generated ASVS/WSTG requirement enums. The old broad `OwaspRequirement` overlay was removed.

## Required Review Before Changing Generated Data

When changing Vanta data or generated controls:

1. Update raw or curated source artifacts only when the source data actually changes.
2. Update curation rules in `GenerateVantaData` when controls/tests are wrongly included or excluded.
3. Regenerate data with `php vendor/bin/testbench security:generate-vanta-data --control-enum-output=src/Controls/ComplianceControl.php`.
3. Keep the relationship conservative: use “supports” evidence, not “satisfies compliance.”
4. Update tests if generated data, curation rules, or report output changes.
5. Run `composer format`, `composer test`, `composer analyse`, and `composer audit`.

When code lacks required behavior, add or suggest `ComplianceGap` instead of weakening an `Evidence` annotation.
