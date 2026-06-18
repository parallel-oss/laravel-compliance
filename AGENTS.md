# Laravel Compliance Agent Guide

This package maps Laravel code evidence to enum-backed controls and external compliance/security framework references.

## Core Rules

- Prefer `#[Evidence(controls: ...)]` with `Parallel\Compliance\Controls\ComplianceControl` when documenting what code does.
- Use `#[Evidence(requirements: ...)]` only when code maps directly to a technical requirement enum such as generated ASVS or WSTG controls.
- Do not state that one code annotation proves GDPR, SOC 2, or OWASP compliance. Treat annotations as evidence that supports broader control narratives.
- Keep code evidence enum-backed. Do not add raw framework IDs directly in attributes.
- Resolve source control metadata, framework mappings, and related tests through generated seed arrays.
- Run `composer format`, `composer test`, `composer analyse`, and `composer audit` after substantive changes.

## Main Files

- `src/Evidence.php` defines the primary attribute.
- `src/Controls/` defines code-facing control enums; `ComplianceControl` is generated from curated seed data.
- `src/Data/` loads generated seed arrays and bridges controls to framework requirements and tests.
- `src/Frameworks/` defines interfaces for external framework references.
- `resources/frameworks/vanta/data/` contains generated package runtime data.
- `config/compliance.php` contains runtime configuration only.
- `skills/` contains Agent Skills that other LLM agents can import from this Composer package.
