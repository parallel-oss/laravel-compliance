<?php

namespace Parallel\Compliance\Data;

readonly class FrameworkRecord
{
    public function __construct(
        public string $slug,
        public string $name,
        public ?string $description,
        public string $source,
        public string $rawFile,
    ) {}

    /**
     * @param  array<string, mixed>  $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            slug: (string) $row['slug'],
            name: (string) $row['name'],
            description: $row['description'] ?? null,
            source: (string) $row['source'],
            rawFile: (string) $row['raw_file'],
        );
    }
}
