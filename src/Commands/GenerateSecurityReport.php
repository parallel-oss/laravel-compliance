<?php

namespace Parallel\Compliance\Commands;

use BackedEnum;
use Illuminate\Console\Command;
use Parallel\Compliance\Frameworks\FrameworkRequirement;
use Parallel\Compliance\Frameworks\FrameworkRequirementMetadata;
use Parallel\Compliance\Frameworks\VantaControl;
use Parallel\Compliance\Mappings\VantaSoc2Mappings;
use Parallel\Compliance\Recommendations\RecommendationCollection;
use Parallel\Compliance\Scanning\EvidenceFinding;
use Parallel\Compliance\Scanning\EvidenceScanner;

class GenerateSecurityReport extends Command
{
    protected $signature = 'security:generate-report
        {--output= : Markdown file to write}
        {--path=* : File or directory paths to scan}
        {--standard=* : Standardized recommendation JSON files to load}
        {--no-code : Omit source code snippets from the report}';

    protected $description = 'Generates a Markdown report of security evidence attributes found in the project';

    private RecommendationCollection $recommendationCollection;

    public function handle(): int
    {
        $this->info('Scanning for security evidence...');

        $this->recommendationCollection = new RecommendationCollection;
        $this->recommendationCollection->loadFromFiles($this->standardPaths());

        $findings = (new EvidenceScanner)->scan($this->scanPaths());
        $output = $this->option('output') ?: config('compliance.report.output');

        $this->writeMarkdownReport($findings, $output);

        $this->info("Security evidence report generated at {$output}.");

        return self::SUCCESS;
    }

    /**
     * @return array<int, string>
     */
    private function scanPaths(): array
    {
        $paths = $this->option('path');

        if ($paths !== []) {
            return $paths;
        }

        return config('compliance.scan_paths', []);
    }

    /**
     * @return array<int, string>
     */
    private function standardPaths(): array
    {
        $paths = $this->option('standard') ?: config('compliance.standards', []);
        $resolvedPaths = [];

        foreach ($paths as $path) {
            $matches = glob($path) ?: [];
            $resolvedPaths = [...$resolvedPaths, ...$matches];
        }

        return $resolvedPaths;
    }

    /**
     * @param  array<int, EvidenceFinding>  $findings
     */
    private function writeMarkdownReport(array $findings, string $output): void
    {
        $markdown = "# Security Evidence Report\n\n";
        $markdown .= 'Generated: '.now()->toIso8601String()."\n\n";

        if ($findings === []) {
            $markdown .= "No evidence attributes were found.\n";
            $this->writeFile($output, $markdown);

            return;
        }

        foreach ($findings as $finding) {
            foreach ($finding->evidence->capabilities as $capability) {
                $capabilityId = $this->enumId($capability);
                $markdown .= '## Capability: '.$this->enumName($capability)."\n\n";
                $markdown .= "- **Capability:** `{$capabilityId}`\n";
                $markdown .= "- **Target:** `{$finding->target}`\n";
                $markdown .= "- **Type:** {$finding->type}\n";
                $markdown .= "- **Status:** {$finding->evidence->status->value}\n";
                $markdown .= "- **Location:** `{$this->relativePath($finding->file)}`:{$finding->startLine}\n";

                $mappedRequirements = $this->mappedRequirements($capabilityId);

                if ($mappedRequirements !== []) {
                    $markdown .= "\n### Framework Mappings\n\n";

                    foreach ($mappedRequirements as $requirement) {
                        $markdown .= $this->frameworkRequirementMarkdown($requirement);
                    }
                }

                $markdown .= $this->evidenceMarkdown($finding);
            }

            foreach ($finding->evidence->controls as $control) {
                $controlId = $this->enumId($control);
                $recommendation = $this->recommendationCollection->getById($controlId);

                $markdown .= '## '.($recommendation->title ?? $controlId)."\n\n";
                $markdown .= "- **Control:** `{$controlId}`\n";
                $markdown .= '- **Source:** '.($recommendation->source ?? 'Unknown')."\n";
                $markdown .= "- **Target:** `{$finding->target}`\n";
                $markdown .= "- **Type:** {$finding->type}\n";
                $markdown .= "- **Status:** {$finding->evidence->status->value}\n";
                $markdown .= "- **Location:** `{$this->relativePath($finding->file)}`:{$finding->startLine}\n";

                if ($recommendation?->description) {
                    $markdown .= "\n### Requirement Description\n\n{$recommendation->description}\n";
                }

                if ($recommendation?->objectives !== []) {
                    $markdown .= "\n### Objectives\n\n";

                    foreach ($recommendation->objectives as $objective) {
                        $markdown .= "- {$objective}\n";
                    }
                }

                if ($recommendation?->references !== []) {
                    $markdown .= "\n### References\n\n";

                    foreach ($recommendation->references as $reference) {
                        $markdown .= "- {$reference}\n";
                    }
                }

                $markdown .= $this->evidenceMarkdown($finding);
            }
        }

        $this->writeFile($output, $markdown);
    }

    private function enumId(mixed $value): string
    {
        if ($value instanceof BackedEnum) {
            return (string) $value->value;
        }

        return (string) $value;
    }

    private function enumName(mixed $value): string
    {
        if ($value instanceof BackedEnum) {
            return str($value->name)->headline()->toString();
        }

        return (string) $value;
    }

    /**
     * @return array<int, mixed>
     */
    private function mappedRequirements(string $capabilityId): array
    {
        return config('compliance.capability_mappings', [])[$capabilityId] ?? [];
    }

    private function frameworkRequirementMarkdown(mixed $requirement): string
    {
        $id = $this->enumId($requirement);
        $metadata = FrameworkRequirementMetadata::get($id);
        $title = $metadata['title'] ?? ($requirement instanceof FrameworkRequirement ? $this->enumName($requirement) : $id);
        $markdown = "- `{$id}` - {$title}\n";

        if (! $metadata) {
            return $markdown;
        }

        $details = [];

        if (! empty($metadata['source'])) {
            $details[] = 'Source: '.$metadata['source'];
        }

        if (! empty($metadata['domain'])) {
            $details[] = 'Domain: '.$metadata['domain'];
        }

        if (! empty($metadata['domains'])) {
            $details[] = 'Domains: '.implode(', ', $metadata['domains']);
        }

        if (! empty($metadata['slug'])) {
            $details[] = 'Vanta slug: `'.$metadata['slug'].'`';
        }

        if ($requirement instanceof VantaControl) {
            $sections = VantaSoc2Mappings::sectionIdsFor($requirement);

            if ($sections !== []) {
                $details[] = 'SOC 2 sections: '.implode(', ', $sections);
            }
        }

        if (! empty($metadata['variants'])) {
            $details[] = 'Variants: '.implode(', ', $metadata['variants']);
        }

        if ($details !== []) {
            $markdown .= '  - '.implode('; ', $details)."\n";
        }

        if (! empty($metadata['description'])) {
            $markdown .= '  - '.$metadata['description']."\n";
        }

        return $markdown;
    }

    private function evidenceMarkdown(EvidenceFinding $finding): string
    {
        $markdown = '';

        if ($finding->evidence->summary) {
            $markdown .= "\n### Evidence Summary\n\n{$finding->evidence->summary}\n";
        }

        if ($finding->evidence->details) {
            $markdown .= "\n### Details\n\n{$finding->evidence->details}\n";
        }

        if ($finding->evidence->links !== []) {
            $markdown .= "\n### Evidence Links\n\n";

            foreach ($finding->evidence->links as $link) {
                $markdown .= "- {$link}\n";
            }
        }

        if (! $this->option('no-code') && config('compliance.report.include_code', true)) {
            $markdown .= "\n### Code\n\n```php\n{$finding->code}\n```\n";
        }

        return $markdown."\n";
    }

    private function writeFile(string $output, string $contents): void
    {
        $directory = dirname($output);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($output, $contents);
    }

    private function relativePath(string $path): string
    {
        $basePath = base_path();

        if (str_starts_with($path, $basePath)) {
            return ltrim(substr($path, strlen($basePath)), DIRECTORY_SEPARATOR);
        }

        return $path;
    }
}
