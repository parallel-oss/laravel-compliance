<?php

namespace Parallel\Compliance\Recommendations;

class RecommendationCollection
{
    /** @var RecommendationData[] */
    private array $recommendations = [];

    public function loadFromFile(string $filePath): void
    {
        if (! is_file($filePath)) {
            return;
        }

        $data = json_decode(file_get_contents($filePath), true);

        if (! is_array($data)) {
            return;
        }

        foreach ($data as $item) {
            $recommendation = RecommendationData::fromArray($item);
            $this->recommendations[$recommendation->id] = $recommendation;
        }
    }

    /**
     * @param  array<int, string>  $filePaths
     */
    public function loadFromFiles(array $filePaths): void
    {
        foreach ($filePaths as $filePath) {
            $this->loadFromFile($filePath);
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
