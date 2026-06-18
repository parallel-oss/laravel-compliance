---
name: map-compliance-evidence
description: Map application behavior to curated enum-backed Laravel Compliance controls and generated technical requirements without overclaiming compliance.
license: MIT
compatibility: PHP 8.4+, Laravel 12+, Composer package parallel-oss/laravel-compliance
---

# Map Compliance Evidence

Use this skill when deciding which `VantaControl` enum cases or generated requirement enums apply to Laravel code.

## Mapping Principle

Map code to what it demonstrably does. Then let `VantaComplianceData` and the generated seed pivots map that control to framework requirements and related tests.

Good:

```php
#[Evidence(
    controls: VantaControl::DCH_1,
    summary: 'Deletes user profile data and related records during account closure.',
)]
```

Avoid:

```php
// Avoid this style unless there is a direct generated technical control enum.
#[Evidence(summary: 'This satisfies GDPR Article 17.')]
```

## Control Guidance

- Use `VantaControl::DCH_1` for code that deletes customer data when customers leave the service.
- Use `VantaControl::DCH_5` for data classification behavior and metadata that helps protect confidential data.
- Use `VantaControl::IAC_*` and `CRY_5` for access, authentication, authorization, password, and MFA behavior.
- Use `VantaControl::MON_*`, `OPS_1`, and `IRO_*` for logging, monitoring, alerting, incident handling, and security incident workflows.
- Use `VantaControl::CHG_*`, `CFG_1`, `NET_5`, `VPM_1`, and `VPM_2` for change management, configuration, hardening, dependency, and vulnerability remediation behavior.
- Use `VantaControl::CRY_3`, `CRY_4`, and `NET_1` for encryption at rest and in transit.
- Use `VantaControl::TPM_1` or `TPM_2` when code or workflows directly support vendor/security review evidence.

Do not use `VantaControl` for policy-only, HR-only, physical-office, board, insurance, meeting-minute, or pure audit-placeholder evidence. Those may exist in raw Vanta resources but are intentionally excluded from code-facing controls.

## Framework Boundaries

- GDPR and SOC 2 mappings come from generated Vanta framework-control/internal-control pivots. They are references, not legal advice or proof of compliance.
- SOC 2 audit evidence normally also needs policies, risk assessments, approvals, logs, tickets, and operating evidence.
- OWASP direct requirements should come from generated ASVS/WSTG requirement enums. The old broad `OwaspRequirement` overlay was removed.

## Required Review Before Changing Generated Data

When changing Vanta data or generated controls:

1. Update raw or curated source artifacts only when the source data actually changes.
2. Update curation rules in `GenerateVantaData` when controls/tests are wrongly included or excluded.
3. Regenerate data with `php vendor/bin/testbench security:generate-vanta-data --control-enum-output=src/Controls/VantaControl.php`.
3. Keep the relationship conservative: use “supports” evidence, not “satisfies compliance.”
4. Update tests if generated data, curation rules, or report output changes.
5. Run `composer format`, `composer test`, `composer analyse`, and `composer audit`.
