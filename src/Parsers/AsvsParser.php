<?php

namespace Parallel\Compliance\Parsers;

class AsvsParser implements ParserInterface
{
    public function parse(string $filePath): array
    {
        $data = json_decode(file_get_contents($filePath), true);

        $standardizedRecommendations = [];

        foreach ($data['Requirements'] as $requirement) {
            $categoryName = $requirement['Name'];
            foreach ($requirement['Items'] as $item) {
                $subCategoryName = $item['Name'];
                foreach ($item['Items'] as $subItem) {
                    $standardizedRecommendations[] = [
                        'source' => 'OWASP_ASVS',
                        'source_id' => $subItem['Shortcode'],
                        'id' => "OWASP_ASVS_{$subItem['Shortcode']}",
                        'name' => $subItem['Description'],
                        'description' => '', // Detailed description if available
                        'reference' => '', // ASVS JSON may not have direct references
                        'categories' => [$categoryName, $subCategoryName],
                        'severity' => '', // If severity is available
                        'objectives' => [], // Extract from description if possible
                        'remediation' => [], // Add if available
                        'cwe' => array_map(function ($cwe) {
                            return "CWE-{$cwe}";
                        }, $subItem['CWE'] ?? []),
                        'nist' => $subItem['NIST'] ?? [],
                        'examples' => [], // Add if available
                        'source_details' => [
                            'level_requirements' => [
                                'L1' => $subItem['L1']['Requirement'] ?? '',
                                'L2' => $subItem['L2']['Requirement'] ?? '',
                                'L3' => $subItem['L3']['Requirement'] ?? '',
                            ],
                        ],
                    ];
                }
            }
        }

        return $standardizedRecommendations;
    }
}
