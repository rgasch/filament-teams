<?php

namespace Rgasch\FilamentTeams\Resources\TeamsResource\Pages;

use Rgasch\FilamentTeams\Resources\TeamsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamsResource::class;

    protected function getTitle(): string
    {
        return trans('filament-teams::teams.resource.title.create');
    }
}
