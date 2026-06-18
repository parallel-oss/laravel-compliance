<?php

namespace Parallel\Compliance\Commands;

use Illuminate\Console\Command;

class ComplianceCommand extends Command
{
    public $signature = 'laravel-compliance';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
