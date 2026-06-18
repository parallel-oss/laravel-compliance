<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;
use Parallel\Compliance\Scanning\ComplianceGapFinding;
use Parallel\Compliance\Scanning\ComplianceGapScanner;

class FindComplianceGaps extends Command
{
    protected $signature = 'security:find-gaps
        {--output= : Markdown file to write}
        {--path=* : File or directory paths to scan}
        {--no-code : Omit source code snippets from the report}';

    protected $description = 'Finds ComplianceGap attributes for missing compliance-related implementation work';

    public function handle(): int
    {
        $this->info('Scanning for compliance gaps...');

        $findings = (new ComplianceGapScanner)->scan($this->scanPaths());
        $output = $this->option('output') ?: config('compliance.gaps.output');

        $this->writeMarkdownReport($findings, $output);

        $this->info("Compliance gap report generated at {$output}.");

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
     * @param  array<int, ComplianceGapFinding>  $findings
     */
    private function writeMarkdownReport(array $findings, string $output): void
    {
        $markdown = "# Compliance Gap Report\n\n";
        $markdown .= 'Generated: '.now()->toIso8601String()."\n\n";

        if ($findings === []) {
            $markdown .= "No compliance gap attributes were found.\n";
            $this->writeFile($output, $markdown);

            return;
        }

        foreach ($findings as $finding) {
            $markdown .= '## Gap: '.$finding->gap->summary."\n\n";
            $markdown .= "- **Target:** `{$finding->target}`\n";
            $markdown .= "- **Type:** {$finding->type}\n";
            $markdown .= "- **Location:** `{$this->relativePath($finding->file)}`:{$finding->startLine}\n";

            if ($finding->gap->owner) {
                $markdown .= "- **Owner:** {$finding->gap->owner}\n";
            }

            if ($finding->gap->controls !== []) {
                $markdown .= '- **Expected Controls:** '.implode(', ', array_map(
                    fn ($control): string => '`'.$control->title().'`',
                    $finding->gap->controls,
                ))."\n";
            }

            if ($finding->gap->details) {
                $markdown .= "\n### Details\n\n{$finding->gap->details}\n";
            }

            if ($finding->gap->remediation) {
                $markdown .= "\n### Remediation\n\n{$finding->gap->remediation}\n";
            }

            if ($finding->gap->links !== []) {
                $markdown .= "\n### Links\n\n";

                foreach ($finding->gap->links as $link) {
                    $markdown .= "- {$link}\n";
                }
            }

            if (! $this->option('no-code') && config('compliance.gaps.include_code', true)) {
                $markdown .= "\n### Code\n\n```php\n{$finding->code}\n```\n";
            }

            $markdown .= "\n";
        }

        $this->writeFile($output, $markdown);
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
