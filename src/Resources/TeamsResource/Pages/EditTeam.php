<?php

namespace Rgasch\FilamentTeams\Resources\TeamsResource\Pages;

use App\Models\User;
use Rgasch\FilamentTeams\Resources\TeamsResource;
use Filament\Resources\Pages\EditRecord;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamsResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $getUser = User::where('email', $data['email'])->first();
        if ($getUser) {
            if (empty($data['password'])) {
                $data['password'] = $getUser->password;
            }
        }
        return $data;
    }

    protected function getTitle(): string
    {
        return trans('filament-teams::teams.resource.title.edit');
    }
}
