<?php

namespace Parallel\Compliance\Commands;

use BackedEnum;
use Illuminate\Console\Command;
use Parallel\Compliance\Controls\ComplianceControl;
use Parallel\Compliance\Controls\Control;
use Parallel\Compliance\Data\FrameworkControlRecord;
use Parallel\Compliance\Data\TestRecord;
use Parallel\Compliance\Data\VantaComplianceData;
use Parallel\Compliance\Frameworks\FrameworkRequirement;
use Parallel\Compliance\Scanning\EvidenceFinding;
use Parallel\Compliance\Scanning\EvidenceScanner;

class GenerateSecurityReport extends Command
{
    protected $signature = 'security:generate-report
        {--output= : Markdown file to write}
        {--path=* : File or directory paths to scan}
        {--no-code : Omit source code snippets from the report}';

    protected $description = 'Generates a Markdown report of security evidence attributes found in the project';

    private VantaComplianceData $vantaData;

    public function handle(): int
    {
        $this->info('Scanning for security evidence...');

        $this->vantaData = VantaComplianceData::fromPackageResources();

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
            foreach ($finding->evidence->controls as $control) {
                $markdown .= '## Control: '.$control->title()."\n\n";
                $markdown .= "- **Control:** `{$control->id()}`\n";
                $markdown .= "- **Source:** {$control->source()}\n";
                $markdown .= "- **Target:** `{$finding->target}`\n";
                $markdown .= "- **Type:** {$finding->type}\n";
                $markdown .= "- **Status:** {$finding->evidence->status->value}\n";
                $markdown .= "- **Location:** `{$this->relativePath($finding->file)}`:{$finding->startLine}\n";

                if ($control->domains() !== []) {
                    $markdown .= '- **Domains:** '.implode(', ', $control->domains())."\n";
                }

                if ($control->description()) {
                    $markdown .= "\n### Control Description\n\n{$control->description()}\n";
                }

                $mappedRequirements = $this->mappedRequirements($control);

                if ($mappedRequirements !== []) {
                    $markdown .= "\n### Framework Mappings\n\n";

                    foreach ($mappedRequirements as $requirement) {
                        $markdown .= $this->frameworkRequirementMarkdown($requirement);
                    }
                }

                $tests = $this->mappedTests($control);

                if ($tests !== []) {
                    $markdown .= "\n### Related Tests\n\n";

                    foreach ($tests as $test) {
                        $markdown .= $this->testMarkdown($test);
                    }
                }

                $markdown .= $this->evidenceMarkdown($finding);
            }

            foreach ($finding->evidence->requirements as $requirement) {
                $markdown .= $this->directRequirementMarkdown($requirement, $finding);
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

    /**
     * @return array<int, FrameworkRequirement>
     */
    private function mappedRequirements(Control $control): array
    {
        if (! $control instanceof ComplianceControl) {
            return [];
        }

        return $this->vantaData->frameworkControlsForInternalControl($control);
    }

    /**
     * @return array<int, TestRecord>
     */
    private function mappedTests(Control $control): array
    {
        if (! $control instanceof ComplianceControl) {
            return [];
        }

        return $this->vantaData->testsForInternalControl($control);
    }

    private function frameworkRequirementMarkdown(FrameworkRequirement $requirement): string
    {
        $id = $requirement->id();
        $title = $requirement->title();
        $markdown = "- `{$id}` - {$title}\n";

        $details = [];

        if ($requirement->source() !== '') {
            $details[] = 'Source: '.$requirement->source();
        }

        if ($requirement->domain()) {
            $details[] = 'Domain: '.$requirement->domain();
        }

        if ($requirement instanceof FrameworkControlRecord && $requirement->variants !== []) {
            $details[] = 'Variants: '.implode(', ', $requirement->variants);
        }

        if ($details !== []) {
            $markdown .= '  - '.implode('; ', $details)."\n";
        }

        if ($requirement->description()) {
            $markdown .= '  - '.$requirement->description()."\n";
        }

        return $markdown;
    }

    private function testMarkdown(TestRecord $test): string
    {
        $markdown = "- `{$test->key}` - {$test->title}\n";
        $details = [];

        if ($test->category) {
            $details[] = 'Category: '.$test->category;
        }

        if ($test->status) {
            $details[] = 'Status: '.$test->status;
        }

        if ($test->integrations !== []) {
            $details[] = 'Integrations: '.implode(', ', $test->integrations);
        }

        if ($details !== []) {
            $markdown .= '  - '.implode('; ', $details)."\n";
        }

        if ($test->description) {
            $markdown .= '  - '.$test->description."\n";
        }

        return $markdown;
    }

    private function directRequirementMarkdown(mixed $requirement, EvidenceFinding $finding): string
    {
        if ($requirement instanceof FrameworkRequirement) {
            $markdown = '## '.$requirement->title()."\n\n";
            $markdown .= "- **Requirement:** `{$requirement->id()}`\n";
            $markdown .= "- **Source:** {$requirement->source()}\n";
            $markdown .= "- **Target:** `{$finding->target}`\n";
            $markdown .= "- **Type:** {$finding->type}\n";
            $markdown .= "- **Status:** {$finding->evidence->status->value}\n";
            $markdown .= "- **Location:** `{$this->relativePath($finding->file)}`:{$finding->startLine}\n";

            if ($requirement->domain()) {
                $markdown .= "- **Domain:** {$requirement->domain()}\n";
            }

            if ($requirement->description()) {
                $markdown .= "\n### Requirement Description\n\n{$requirement->description()}\n";
            }

            return $markdown.$this->evidenceMarkdown($finding);
        }

        $requirementId = $this->enumId($requirement);
        $markdown = "## {$requirementId}\n\n";
        $markdown .= "- **Requirement:** `{$requirementId}`\n";
        $markdown .= "- **Target:** `{$finding->target}`\n";
        $markdown .= "- **Type:** {$finding->type}\n";
        $markdown .= "- **Status:** {$finding->evidence->status->value}\n";
        $markdown .= "- **Location:** `{$this->relativePath($finding->file)}`:{$finding->startLine}\n";

        return $markdown.$this->evidenceMarkdown($finding);
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
