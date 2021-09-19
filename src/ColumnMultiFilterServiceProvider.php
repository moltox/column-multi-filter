<?php

namespace Moltox\ColumnMultiFilter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ColumnMultiFilterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('column-multi-filter')
            ->hasConfigFile()
     //       ->hasViews()
     //       ->hasMigration('create_column_multi_filter_table')
     //       ->hasCommand(ColumnMultiFilterCommand::class)
        ;
    }
}
