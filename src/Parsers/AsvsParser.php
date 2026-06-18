<?php

namespace Parallel\Compliance\Parsers;

class AsvsParser implements ParserInterface
{
    public function parse(string $json, ?string $version = null): array
    {
        $data = json_decode($json, true);
        $version ??= (string) ($data['Version'] ?? $data['version'] ?? 'latest');

        return $this->walkItems(
            $data['Requirements'] ?? $data['requirements'] ?? [],
            [],
            $version
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @param  array<int, string>  $categories
     * @return array<int, array<string, mixed>>
     */
    private function walkItems(array $items, array $categories, string $version): array
    {
        $recommendations = [];

        foreach ($items as $item) {
            $children = $item['Items'] ?? $item['items'] ?? [];
            $name = $item['Name'] ?? $item['name'] ?? $item['ShortName'] ?? null;
            $nextCategories = $name ? [...$categories, (string) $name] : $categories;

            if ($children !== []) {
                $recommendations = [
                    ...$recommendations,
                    ...$this->walkItems($children, $nextCategories, $version),
                ];

                continue;
            }

            $sourceId = $item['Shortcode'] ?? $item['shortcode'] ?? $item['id'] ?? null;
            $description = $item['Description'] ?? $item['description'] ?? null;

            if (! $sourceId || ! $description) {
                continue;
            }

            $recommendations[] = [
                'source' => 'OWASP_ASVS',
                'source_version' => $version,
                'source_id' => (string) $sourceId,
                'id' => "OWASP_ASVS:{$version}:{$sourceId}",
                'title' => (string) $description,
                'description' => null,
                'categories' => $nextCategories,
                'objectives' => [],
                'references' => [],
                'mappings' => [
                    'cwe' => array_map(
                        fn ($cwe) => str_starts_with((string) $cwe, 'CWE-') ? (string) $cwe : "CWE-{$cwe}",
                        $item['CWE'] ?? $item['cwe'] ?? []
                    ),
                    'nist' => $item['NIST'] ?? $item['nist'] ?? [],
                ],
                'levels' => $this->extractLevels($item),
                'tags' => ['application-security-verification'],
                'raw' => [
                    'ordinal' => $item['Ordinal'] ?? $item['ordinal'] ?? null,
                    'source' => $item,
                ],
            ];
        }

        return $recommendations;
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function extractLevels(array $item): array
    {
        $levels = [];

        foreach ($item as $key => $value) {
            if (preg_match('/^L\d+$/', (string) $key) !== 1) {
                continue;
            }

            $levels[$key] = $value;
        }

        return $levels;
    }
}
