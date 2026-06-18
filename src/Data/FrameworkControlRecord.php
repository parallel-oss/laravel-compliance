<?php

namespace Parallel\Compliance\Data;

use Parallel\Compliance\Frameworks\FrameworkRequirement;

readonly class FrameworkControlRecord implements FrameworkRequirement
{
    /**
     * @param  array<int, string>  $variants
     */
    public function __construct(
        public string $frameworkSlug,
        public string $frameworkName,
        public string $code,
        public string $title,
        public ?string $description,
        public ?string $principleId,
        public ?string $principleName,
        public array $variants,
        public string $source,
    ) {}

    /**
     * @param  array<string, mixed>  $row
     */
    public static function fromArray(array $row, FrameworkRecord $framework): self
    {
        return new self(
            frameworkSlug: (string) $row['framework_slug'],
            frameworkName: $framework->name,
            code: (string) $row['code'],
            title: (string) $row['title'],
            description: $row['description'] ?? null,
            principleId: $row['principle_id'] ?? null,
            principleName: $row['principle_name'] ?? null,
            variants: array_values(array_map('strval', $row['variants'] ?? [])),
            source: $framework->name,
        );
    }

    public function id(): string
    {
        return $this->prefix().':'.$this->code;
    }

    public function source(): string
    {
        return $this->source;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function domain(): ?string
    {
        return $this->principleName;
    }

    private function prefix(): string
    {
        return match ($this->frameworkSlug) {
            'soc2' => 'SOC2',
            'gdpr' => 'GDPR',
            'ccpa' => 'CCPA',
            'pciDss4' => 'PCIDSS4',
            default => strtoupper(preg_replace('/[^A-Za-z0-9]+/', '', $this->frameworkSlug) ?: $this->frameworkSlug),
        };
    }
}
