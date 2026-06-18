<?php

namespace Parallel\Compliance\Recommendations;

class RecommendationData
{
    /**
     * @param  array<int, string>  $categories
     * @param  array<int, string>  $objectives
     * @param  array<int, string>  $references
     * @param  array<string, array<int, string>|string>  $mappings
     * @param  array<string, mixed>  $levels
     * @param  array<int, string>  $tags
     * @param  array<string, mixed>  $raw
     */
    public function __construct(
        public string $id,
        public string $source,
        public string $sourceId,
        public string $title,
        public ?string $sourceVersion = null,
        public ?string $description = null,
        public array $categories = [],
        public array $objectives = [],
        public array $references = [],
        public array $mappings = [],
        public array $levels = [],
        public array $tags = [],
        public array $raw = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            source: (string) $data['source'],
            sourceId: (string) ($data['source_id'] ?? $data['sourceId']),
            title: (string) ($data['title'] ?? $data['name']),
            sourceVersion: isset($data['source_version']) ? (string) $data['source_version'] : ($data['sourceVersion'] ?? null),
            description: $data['description'] ?? null,
            categories: $data['categories'] ?? [],
            objectives: $data['objectives'] ?? [],
            references: $data['references'] ?? (isset($data['reference']) && $data['reference'] !== '' ? [$data['reference']] : []),
            mappings: [
                ...($data['mappings'] ?? []),
                ...(! empty($data['cwe']) ? ['cwe' => $data['cwe']] : []),
                ...(! empty($data['nist']) ? ['nist' => $data['nist']] : []),
            ],
            levels: $data['levels'] ?? ($data['source_details']['level_requirements'] ?? []),
            tags: $data['tags'] ?? [],
            raw: $data['raw'] ?? ($data['source_details'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'source' => $this->source,
            'source_version' => $this->sourceVersion,
            'source_id' => $this->sourceId,
            'title' => $this->title,
            'description' => $this->description,
            'categories' => $this->categories,
            'objectives' => $this->objectives,
            'references' => $this->references,
            'mappings' => $this->mappings,
            'levels' => $this->levels,
            'tags' => $this->tags,
            'raw' => $this->raw,
        ];
    }
}
