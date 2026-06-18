<?php

namespace Parallel\Compliance\Recommendations;

class RecommendationData
{
    public string $source;

    public string $source_id;

    public string $id;

    public string $name;

    public string $description;

    public string $reference;

    public array $categories;

    public string $severity;

    public array $objectives;

    public array $remediation;

    public array $cwe;

    public array $nist;

    public array $examples;

    public array $source_details;

    public function __construct(array $data)
    {
        $this->source = $data['source'];
        $this->source_id = $data['source_id'];
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->reference = $data['reference'];
        $this->categories = $data['categories'];
        $this->severity = $data['severity'];
        $this->objectives = $data['objectives'];
        $this->remediation = $data['remediation'];
        $this->cwe = $data['cwe'];
        $this->nist = $data['nist'];
        $this->examples = $data['examples'];
        $this->source_details = $data['source_details'];
    }
}
