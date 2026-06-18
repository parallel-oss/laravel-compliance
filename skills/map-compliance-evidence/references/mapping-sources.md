# Mapping Sources

This package ships conservative, generated mappings between curated internal controls and external framework references.

## Source Seed Data

Raw source resources live under `resources/frameworks/vanta/raw`. Generated, package-runtime data lives under `resources/frameworks/vanta/data`.

- `frameworks.php`: framework catalog rows.
- `framework-controls.php`: framework requirement sections from raw source framework files.
- `internal-controls.php`: curated engineering-relevant source controls that back the public `ComplianceControl` enum.
- `tests.php`: curated engineering-relevant monitoring tests.
- `framework-control-internal-control.php`: generated framework-control to internal-control pivots.
- `internal-control-test.php`: curated internal-control to test pivots.

Regenerate these files with:

```bash
php vendor/bin/testbench security:generate-vanta-data \
    --control-enum-output=src/Controls/ComplianceControl.php
```

## GDPR

GDPR framework references come from raw framework sections and generated framework-control/internal-control pivots. They are not legal advice and do not prove legal compliance.

## SOC 2

SOC 2 mappings reference AICPA Trust Services Criteria sections through generated framework-control rows. They are section-level references because SOC 2 evidence usually combines code, policies, tickets, logs, approvals, monitoring, and audit samples.

Primary public source: AICPA Trust Services Criteria for Security, Availability, Processing Integrity, Confidentiality, and Privacy, with 2022 revised points of focus.

## OWASP

OWASP mappings use generated exact requirement enums created from imported OWASP ASVS and WSTG JSON. Prefer generated exact requirements when code maps to a specific ASVS or WSTG requirement.

Primary public sources:

- OWASP ASVS release JSON.
- OWASP WSTG checklist JSON.

## Important Boundary

Mappings mean “this evidence may support this framework reference.” They do not mean “this code satisfies this control” or “this product is compliant.”
