<?php

namespace Parallel\Compliance\Data;

readonly class ControlRecord
{
    /**
     * @param  array<int, string>  $domains
     */
    public function __construct(
        public string $vantaId,
        public string $externalId,
        public string $name,
        public ?string $description,
        public array $domains,
        public string $source,
    ) {}

    /**
     * @param  array<string, mixed>  $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            vantaId: (string) $row['vanta_id'],
            externalId: (string) $row['external_id'],
            name: (string) $row['name'],
            description: $row['description'] ?? null,
            domains: array_values(array_map('strval', $row['domains'] ?? [])),
            source: (string) $row['source'],
        );
    }

    public function id(): string
    {
        return 'VANTA:'.$this->externalId;
    }
}
