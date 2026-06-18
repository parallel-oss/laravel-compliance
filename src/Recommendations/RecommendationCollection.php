<?php

namespace Parallel\Compliance\Recommendations;

class RecommendationCollection
{
    /** @var RecommendationData[] */
    private array $recommendations = [];

    public function loadFromFile(string $filePath): void
    {
        $data = json_decode(file_get_contents($filePath), true);
        foreach ($data as $item) {
            $this->recommendations[$item['id']] = new RecommendationData($item);
        }
    }

    public function getById(string $id): ?RecommendationData
    {
        return $this->recommendations[$id] ?? null;
    }

    public function all(): array
    {
        return $this->recommendations;
    }
}
