<?php

namespace Parallel\Compliance\Parsers;

class WstgParser implements ParserInterface
{
    public function parse(string $json, ?string $version = null): array
    {
        $data = json_decode($json, true);
        $version ??= (string) ($data['version'] ?? 'latest');

        $standardizedRecommendations = [];

        foreach (($data['categories'] ?? []) as $categoryName => $categoryData) {
            $categoryId = $categoryData['id'];
            foreach (($categoryData['tests'] ?? []) as $test) {
                $standardizedRecommendations[] = [
                    'source' => 'OWASP_WSTG',
                    'source_version' => $version,
                    'source_id' => $test['id'],
                    'id' => "OWASP_WSTG:{$version}:{$test['id']}",
                    'title' => $test['name'],
                    'description' => null,
                    'categories' => [$categoryName],
                    'objectives' => $test['objectives'] ?? [],
                    'references' => array_filter([$test['reference'] ?? null]),
                    'mappings' => [],
                    'levels' => [],
                    'tags' => ['web-security-testing'],
                    'raw' => [
                        'category_id' => $categoryId,
                        'source' => $test,
                    ],
                ];
            }
        }

        return $standardizedRecommendations;
    }
}
