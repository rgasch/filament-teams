<?php

namespace Rgasch\FilamentTeams;

use Filament\PluginServiceProvider;
use Rgasch\FilamentTeams\Resources\TeamsResource;
use Spatie\LaravelPackageTools\Package;


class FilamentTeamsProvider extends PluginServiceProvider
{
    public static string $name = 'filament-teams';

    protected array $resources = [
        TeamsResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('filament-teams');
    }

    public function boot(): void
    {
        parent::boot();

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-teams');

        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'filament-teams-config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/filament-teams'),
        ], 'filament-teams-translations');
    }
}
