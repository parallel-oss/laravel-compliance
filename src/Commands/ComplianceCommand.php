<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;

class ComplianceCommand extends Command
{
    public $signature = 'laravel-compliance:publish-skills
        {--path= : Directory where Cursor project skills should be published}
        {--force : Overwrite existing skill files}';

    public $description = 'Publishes Laravel Compliance Cursor skills into the current project';

    public function handle(): int
    {
        $source = dirname(__DIR__, 2).'/skills';
        $destination = $this->publishPath();

        if (! is_dir($source)) {
            $this->error("Package skills directory not found at {$source}.");

            return self::FAILURE;
        }

        if (! is_dir($destination) && ! mkdir($destination, 0755, true) && ! is_dir($destination)) {
            $this->error("Unable to create skills directory at {$destination}.");

            return self::FAILURE;
        }

        $published = 0;
        $skipped = 0;

        foreach ($this->skillDirectories($source) as $skillDirectory) {
            $skillName = basename($skillDirectory);
            $targetDirectory = $destination.DIRECTORY_SEPARATOR.$skillName;

            if (is_dir($targetDirectory) && ! $this->option('force')) {
                $this->warn("Skipping {$skillName}; already exists. Use --force to overwrite.");
                $skipped++;

                continue;
            }

            $this->copyDirectory($skillDirectory, $targetDirectory);
            $this->line("Published {$skillName}.");
            $published++;
        }

        $this->info("Published {$published} Cursor skill(s) to {$destination}.");

        if ($skipped > 0) {
            $this->comment("Skipped {$skipped} existing skill(s).");
        }

        return self::SUCCESS;
    }

    private function publishPath(): string
    {
        $path = $this->option('path');

        if (is_string($path) && $path !== '') {
            return $this->absolutePath($path);
        }

        return getcwd().DIRECTORY_SEPARATOR.'.cursor'.DIRECTORY_SEPARATOR.'skills';
    }

    private function absolutePath(string $path): string
    {
        if (str_starts_with($path, DIRECTORY_SEPARATOR) || preg_match('/^[A-Za-z]:[\\\\\\/]/', $path) === 1) {
            return $path;
        }

        return getcwd().DIRECTORY_SEPARATOR.$path;
    }

    /**
     * @return array<int, string>
     */
    private function skillDirectories(string $source): array
    {
        $directories = array_filter(
            glob($source.DIRECTORY_SEPARATOR.'*') ?: [],
            fn (string $path): bool => is_dir($path) && is_file($path.DIRECTORY_SEPARATOR.'SKILL.md'),
        );

        sort($directories, SORT_NATURAL);

        return $directories;
    }

    private function copyDirectory(string $source, string $destination): void
    {
        if (! is_dir($destination) && ! mkdir($destination, 0755, true) && ! is_dir($destination)) {
            throw new \RuntimeException("Unable to create directory at {$destination}.");
        }

        foreach (glob($source.DIRECTORY_SEPARATOR.'*') ?: [] as $item) {
            $target = $destination.DIRECTORY_SEPARATOR.basename($item);

            if (is_dir($item)) {
                $this->copyDirectory($item, $target);

                continue;
            }

            copy($item, $target);
        }
    }
}
