# Laravel Compliance Agent Guide

This package maps Laravel code evidence to enum-backed controls and external compliance/security framework references.

## Core Rules

- Prefer `#[Evidence(controls: ...)]` with `Parallel\Compliance\Controls\VantaControl` when documenting what code does.
- Use `#[Evidence(requirements: ...)]` only when code maps directly to a technical requirement enum such as generated ASVS or WSTG controls.
- Do not state that one code annotation proves GDPR, SOC 2, or OWASP compliance. Treat annotations as evidence that supports broader control narratives.
- Keep mappings enum-backed. Do not add string framework IDs directly in attributes or config mappings when an enum can represent them.
- Run `composer format`, `composer test`, `composer analyse`, and `composer audit` after substantive changes.

## Main Files

- `src/Evidence.php` defines the primary attribute.
- `src/Controls/` defines code-facing control enums.
- `src/Frameworks/` defines enum-backed external framework references.
- `src/Mappings/` bridges controls to framework requirements in one place.
- `config/compliance.php` contains runtime configuration only.
- `skills/` contains Agent Skills that other LLM agents can import from this Composer package.
