# Laravel Compliance Agent Guide

This package maps Laravel code evidence to enum-backed internal capabilities and external compliance/security framework references.

## Core Rules

- Prefer `#[Evidence(capabilities: ...)]` when documenting what code does, such as deleting user data, exporting user data, checking authorization, or logging security events.
- Use `#[Evidence(controls: ...)]` only when code maps directly to a technical requirement enum such as generated ASVS or WSTG controls.
- Do not state that one code annotation proves GDPR, SOC 2, or OWASP compliance. Treat annotations as evidence that supports broader control narratives.
- Keep mappings enum-backed. Do not add string framework IDs directly in attributes or config mappings when an enum can represent them.
- Run `composer format`, `composer test`, `composer analyse`, and `composer audit` after substantive changes.

## Main Files

- `src/Evidence.php` defines the primary attribute.
- `src/Capabilities/CommonCapability.php` defines built-in internal capabilities.
- `src/Frameworks/` defines enum-backed external framework references.
- `config/compliance.php` maps internal capabilities to GDPR, SOC 2, and OWASP references.
- `skills/` contains Agent Skills that other LLM agents can import from this Composer package.
