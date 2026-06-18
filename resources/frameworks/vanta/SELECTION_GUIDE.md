# Vanta Data Selection Guide

This package is an internal evidence-mapping tool for high-compliance Laravel applications. Its job is to help engineers mark code with meaningful, enum-backed evidence and then generate reports that explain how that evidence supports controls, framework requirements, and audit narratives.

The goal is not to claim that a code annotation proves compliance. The goal is to make code-level evidence discoverable, reviewable, and reusable across SOC 2, GDPR, OWASP, and other frameworks.

## What We Care About

We care about framework and control data when it helps answer one of these questions:

- What does this code prove or support?
- Which control objective does this implementation relate to?
- Which framework requirements may this evidence support?
- What would an auditor, customer, or non-specialist reader need to understand the evidence?
- Can an LLM agent use this data to choose the right enum and write a useful evidence summary?

## Preferred Evidence Model

Application code should usually reference a code-facing control enum:

```php
#[Evidence(
    controls: VantaControl::DCH_1,
    summary: 'Deletes customer data after account closure.'
)]
```

Direct framework requirements should be used only when the code maps directly to a specific technical requirement:

```php
#[Evidence(
    requirements: OwaspAsvs500Requirements::V2_1_1,
    summary: 'Password reset tokens are signed, single-use, and expire after 15 minutes.'
)]
```

Mappings from controls to frameworks should live in one mapping layer. Reports should derive framework coverage from those mappings rather than asking engineers to sprinkle GDPR, SOC 2, or PCI identifiers through application code.

## What To Keep

Keep data that is useful for code evidence, report generation, or agent guidance:

- Control IDs, external IDs, slugs, titles, descriptions, domains, and categories.
- Framework requirement IDs, titles, descriptions, variants, and section hierarchy.
- Mappings from controls to framework requirements.
- Continuous monitoring tests and the controls they validate.
- Test entities when they explain what concrete resources are evaluated.
- Frameworks that are likely to influence code or engineering operations, even if they are not immediately used.

Especially keep controls related to:

- Access control, authentication, authorization, MFA, least privilege, and access reviews.
- Encryption, secrets management, key management, data at rest, and data in transit.
- Data retention, deletion, export, access requests, consent, privacy notices, and disclosure records.
- Logging, audit trails, monitoring, alerting, incident response, and breach notification.
- Secure SDLC, change management, dependency management, vulnerability scanning, patching, code review, and penetration testing.
- Backup, recovery, availability, data replication, and resilience.
- Vendor management, subprocessors, data processing agreements, and third-party risk.
- AI governance, AI safety, AI data usage, prompt injection, model monitoring, and AI incident response.

## What To Deprioritize

Do not make code-facing enums for data that is mostly operational, HR, legal, physical, or policy-only unless we later add non-code evidence types.

Examples:

- Board charters and board meetings.
- Background checks and performance reviews.
- Office physical access and visitor logs.
- Insurance coverage.
- Whistleblower policies.
- Policy approval status.
- Pure audit-document placeholders.

These may still belong in raw resources or future non-code evidence reports. They should not dominate code annotations.

## Raw Data Policy

Raw Vanta responses live under `resources/frameworks/vanta/`.

Raw data should remain close to the original MCP response shape so we can regenerate enums, mappings, and documentation later. Generated code should be deterministic and should not require another Vanta call unless the source data changes.

Do not manually edit raw JSON unless correcting a known capture problem. If generated code looks wrong, fix the generator or mapping rules instead.

## Triage Questions

When reviewing a framework or control, ask:

1. Is this relevant to application code, infrastructure code, or engineering workflow?
2. Is it better represented as code evidence, operational evidence, policy evidence, or audit evidence?
3. Should it become a code-facing control enum?
4. Should it only be a mapped framework requirement?
5. Does it need title, description, domain, variants, or test metadata in reports?
6. Can this be mapped automatically from Vanta data, or does it need human judgment?

## Current Direction

For now, Vanta controls are the best candidate for the primary code-facing control catalog because they are practical, explanatory, and already mapped across frameworks. The package should use them as inspiration and as source-linked controls, while keeping the implementation flexible enough to add non-Vanta catalogs later.

Framework-specific IDs should remain framework requirements, not code-facing controls. Code should say what it does. Mappings should explain which frameworks that evidence supports.
