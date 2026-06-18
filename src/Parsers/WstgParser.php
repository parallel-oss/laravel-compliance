<?php

namespace Parallel\Compliance\Parsers;

class WstgParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $data = json_decode(file_get_contents($filePath), true);

        $standardizedRecommendations = [];

        foreach ($data['categories'] as $categoryName => $categoryData) {
            $categoryId = $categoryData['id'];
            foreach ($categoryData['tests'] as $test) {
                $standardizedRecommendations[] = [
                    'source' => 'OWASP_WSTG',
                    'source_id' => $test['id'],
                    'id' => "OWASP_WSTG_{$test['id']}",
                    'name' => $test['name'],
                    'description' => '', // WSTG JSON doesn't have a description
                    'reference' => $test['reference'],
                    'categories' => [$categoryName],
                    'severity' => '', // If severity is available
                    'objectives' => $test['objectives'] ?? [],
                    'remediation' => [], // Add if available
                    'cwe' => [], // Add if available
                    'nist' => [], // Add if available
                    'examples' => [], // Add if available
                    'source_details' => [
                        'category_id' => $categoryId,
                    ],
                ];
            }
        }

        return $standardizedRecommendations;
    }
}
