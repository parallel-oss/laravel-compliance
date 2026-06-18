<?php

namespace Parallel\Compliance;

use Parallel\Compliance\Commands\ComplianceCommand;
use Parallel\Compliance\Commands\FindComplianceGaps;
use Parallel\Compliance\Commands\GenerateSecurityReport;
use Parallel\Compliance\Commands\GenerateVantaData;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ComplianceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-compliance')
            ->hasConfigFile()
            ->hasCommand(ComplianceCommand::class)
            ->hasCommand(FindComplianceGaps::class)
            ->hasCommand(GenerateSecurityReport::class)
            ->hasCommand(GenerateVantaData::class);
    }
}
