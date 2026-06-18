---
name: map-compliance-evidence
description: Map application behavior to enum-backed Laravel Compliance capabilities and framework references for GDPR, SOC 2, and OWASP without overclaiming compliance.
license: MIT
compatibility: PHP 8.4+, Laravel 12+, Composer package parallel-oss/laravel-compliance
---

# Map Compliance Evidence

Use this skill when deciding which `CommonCapability` enum cases or framework mappings apply to Laravel code.

## Mapping Principle

Map code to what it demonstrably does. Then let `config/compliance.php` map that capability to GDPR, SOC 2, and OWASP references.

Good:

```php
#[Evidence(
    capabilities: CommonCapability::UserDataErasure,
    summary: 'Deletes user profile data and related records during account closure.',
)]
```

Avoid:

```php
// Avoid this style unless there is a direct generated technical control enum.
#[Evidence(summary: 'This satisfies GDPR Article 17.')]
```

## Common Capability Guidance

- Use `UserDataErasure` when code deletes, anonymizes, or irreversibly removes personal data.
- Use `UserDataExport` when code produces a structured export of user-provided personal data.
- Use `UserDataAccess` when code lets a user or operator retrieve personal data for access requests.
- Use `UserDataRectification` when code corrects inaccurate personal data.
- Use `UserDataRestriction` when code suppresses or limits processing of personal data.
- Use `UserDataObjection` when code records or enforces objections to processing.
- Use `DataRetention` when code enforces retention windows, purge schedules, or disposal rules.
- Use `DataMinimization` when code avoids unnecessary collection, storage, or exposure of personal data.
- Use `PurposeLimitation` when code records or enforces processing purposes.
- Use `ConsentCapture` when code records opt-in consent state and context.
- Use `ConsentWithdrawal` when code records withdrawal or disables consent-based processing.
- Use `PrivacyNotice` when code presents, versions, or records privacy notices.
- Use `ProcessingRecords` when code records processing activity metadata.
- Use `ProcessorManagement` when code manages third-party processors, vendors, or subprocessors.
- Use `PrivacyImpactAssessment` when code supports DPIA or privacy risk assessment workflows.
- Use `BreachNotification` when code detects, records, escalates, or notifies on personal data breaches.
- Use `Authentication`, `Authorization`, `SessionManagement`, `InputValidation`, `OutputEncoding`, `SecureConfiguration`, `SecretsManagement`, `DependencyManagement`, `SecurityMonitoring`, `IncidentResponse`, `ChangeManagement`, `EncryptionAtRest`, and `EncryptionInTransit` for OWASP/security capabilities.

## Framework Boundaries

- GDPR mappings are references to relevant articles. They are not legal advice and do not prove legal compliance.
- SOC 2 mappings are references to Trust Services Criteria families. SOC 2 audit evidence normally also needs policies, risk assessments, approvals, logs, tickets, and operating evidence.
- OWASP mappings may be broad built-in references or exact generated ASVS/WSTG requirement enums. Prefer generated controls when a specific technical requirement is known.

## Required Review Before Adding New Mappings

When adding or changing mappings:

1. Add or reuse an enum case. Do not use raw strings.
2. Map every new `CommonCapability` case in `config/compliance.php`.
3. Keep the relationship conservative: use “supports” evidence, not “satisfies compliance.”
4. Update tests if a mapping table or enum changes.
5. Run `composer format`, `composer test`, `composer analyse`, and `composer audit`.
