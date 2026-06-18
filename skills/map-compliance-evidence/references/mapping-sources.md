# Mapping Sources

This package ships conservative, enum-backed mappings between internal capabilities and external framework references.

## GDPR

GDPR mappings reference Regulation (EU) 2016/679 articles. The most commonly mapped built-in capabilities use:

- Article 5: principles relating to processing of personal data.
- Article 6: lawfulness of processing.
- Article 7: conditions for consent.
- Articles 12-14: transparent information and notices.
- Article 15: right of access.
- Article 16: right to rectification.
- Article 17: right to erasure.
- Article 18: right to restriction of processing.
- Article 19: notification obligation regarding rectification, erasure, or restriction.
- Article 20: right to data portability.
- Article 21: right to object.
- Article 24: responsibility of the controller.
- Article 25: data protection by design and by default.
- Article 28: processor obligations.
- Article 30: records of processing activities.
- Article 32: security of processing.
- Articles 33-34: personal data breach notification.
- Article 35: data protection impact assessment.

Primary public source: EUR-Lex Regulation (EU) 2016/679 and official national publication mirrors.

## SOC 2

SOC 2 mappings reference AICPA Trust Services Criteria sections. They are intentionally mapped at the section level because SOC 2 evidence usually combines code, policies, tickets, logs, approvals, monitoring, and audit samples.

- A1.1-A1.3: availability.
- C1.1-C1.2: confidentiality.
- CC1.1-CC5.3: control environment, communication, risk assessment, monitoring, and control activities.
- CC6.1-CC6.8: logical and physical access controls.
- CC7.1-CC7.5: system operations, monitoring, and incident response.
- CC8.1: change management.
- CC9.1-CC9.2: risk mitigation.
- PI1.1-PI1.5: processing integrity.
- P1.1-P8.1: privacy criteria, including notice, consent, collection, use/retention/disposal, access, disclosure/notification, quality, and monitoring/enforcement.

Primary public source: AICPA Trust Services Criteria for Security, Availability, Processing Integrity, Confidentiality, and Privacy, with 2022 revised points of focus.

The built-in SOC 2 section list was also checked against the purchased SOC 2 framework requirements exposed by Vanta's read-only MCP tools. Vanta implementation controls such as `DCH-6`, `IAC-2`, `IRO-2`, and `VPM-2` are useful evidence patterns, but this public package maps to SOC 2 criteria sections rather than a private Vanta control catalog.

## OWASP

OWASP mappings use two levels:

- Broad package enums in `OwaspRequirement` for ASVS chapters and WSTG categories.
- Generated exact requirement enums created from imported OWASP ASVS and WSTG JSON.

Prefer generated exact controls when code maps to a specific ASVS or WSTG requirement. Use broad OWASP mappings for capability-level evidence and discovery.

Primary public sources:

- OWASP ASVS release JSON.
- OWASP WSTG checklist JSON.

## Important Boundary

Mappings mean “this evidence may support this framework reference.” They do not mean “this code satisfies this control” or “this product is compliant.”
