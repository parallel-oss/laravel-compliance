---
name: map-compliance-evidence
description: Map application behavior to enum-backed Laravel Compliance controls and framework references for GDPR, SOC 2, and OWASP without overclaiming compliance.
license: MIT
compatibility: PHP 8.4+, Laravel 12+, Composer package parallel-oss/laravel-compliance
---

# Map Compliance Evidence

Use this skill when deciding which `VantaControl` enum cases or generated requirement enums apply to Laravel code.

## Mapping Principle

Map code to what it demonstrably does. Then let `src/Mappings` map that control to GDPR, SOC 2, and OWASP references.

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

- Use `VantaControl::DCH_1`, `DCH_6`, or `DCH_10` for code that deletes or disposes of customer/personal data.
- Use `VantaControl::DCH_8`, `DCH_9`, or `IRO_4` for data subject access/export/disclosure accounting flows.
- Use `VantaControl::PRI_9`, `PRI_10`, `PRI_11`, or `PRI_12` for consent and opt-out behavior.
- Use `VantaControl::IAC_*` and `CRY_5` for access, authentication, authorization, password, and MFA behavior.
- Use `VantaControl::MON_*`, `OPS_1`, and `IRO_*` for logging, monitoring, alerting, incident handling, and breach notification behavior.
- Use `VantaControl::CHG_*`, `CFG_1`, `NET_5`, `VPM_1`, and `VPM_2` for change management, configuration, hardening, dependency, and vulnerability remediation behavior.
- Use `VantaControl::CRY_3`, `CRY_4`, and `NET_1` for encryption at rest and in transit.

## Framework Boundaries

- GDPR mappings are references to relevant articles. They are not legal advice and do not prove legal compliance.
- SOC 2 mappings are references to Trust Services Criteria sections. SOC 2 audit evidence normally also needs policies, risk assessments, approvals, logs, tickets, and operating evidence.
- OWASP mappings may be broad built-in references or exact generated ASVS/WSTG requirement enums. Prefer generated controls when a specific technical requirement is known.

## Required Review Before Adding New Mappings

When adding or changing mappings:

1. Add or reuse an enum case. Do not use raw strings.
2. Map new controls in `src/Mappings/VantaControlSoc2Mappings.php` and/or `src/Mappings/VantaControlFrameworkMappings.php`.
3. Keep the relationship conservative: use “supports” evidence, not “satisfies compliance.”
4. Update tests if a mapping table or enum changes.
5. Run `composer format`, `composer test`, `composer analyse`, and `composer audit`.
