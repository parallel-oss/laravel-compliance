<?php

namespace Parallel\Compliance\Data;

readonly class TestRecord
{
    /**
     * @param  array<int, string>  $integrations
     */
    public function __construct(
        public string $vantaTestId,
        public string $key,
        public string $title,
        public ?string $description,
        public ?string $failureDescription,
        public ?string $remediationInstructions,
        public ?string $category,
        public ?string $status,
        public array $integrations,
    ) {}

    /**
     * @param  array<string, mixed>  $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            vantaTestId: (string) $row['vanta_test_id'],
            key: (string) $row['key'],
            title: (string) $row['title'],
            description: $row['description'] ?? null,
            failureDescription: $row['failure_description'] ?? null,
            remediationInstructions: $row['remediation_instructions'] ?? null,
            category: $row['category'] ?? null,
            status: $row['status'] ?? null,
            integrations: array_values(array_map('strval', $row['integrations'] ?? [])),
        );
    }
}
