<?php

namespace Parallel\Compliance;

use Parallel\Compliance\Commands\GenerateRecommendationEnums;
use Parallel\Compliance\Commands\GenerateSecurityReport;
use Parallel\Compliance\Commands\GenerateVantaData;
use Parallel\Compliance\Commands\TransformAsvsJson;
use Parallel\Compliance\Commands\TransformWstgJson;
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
            ->hasCommand(GenerateRecommendationEnums::class)
            ->hasCommand(GenerateSecurityReport::class)
            ->hasCommand(GenerateVantaData::class)
            ->hasCommand(TransformAsvsJson::class)
            ->hasCommand(TransformWstgJson::class);
    }
}
