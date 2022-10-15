<?php

namespace Rgasch\FilamentTeams\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Rgasch\FilamentTeams\Resources\TeamsResource\Pages;
use STS\FilamentImpersonate\Impersonate;

class TeamsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static function getNavigationLabel(): string
    {
        return trans('filament-teams::teams.resource.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('filament-teams::teams.resource.label');
    }

    public static function getLabel(): string
    {
        return trans('filament-teams::teams.resource.single');
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('filament-teams.group');
    }

    protected function getTitle(): string
    {
        return trans('filament-teams::teams.resource.title.resource');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label(trans('filament-teams::teams.resource.name')),
                TextInput::make('email')->email()->required()->label(trans('filament-teams::teams.resource.email')),
                Forms\Components\TextInput::make('password')->label(trans('filament-teams::teams.resource.password'))
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : ""),
                Forms\Components\MultiSelect::make('roles')->relationship('roles', 'name')->label(trans('filament-teams::teams.resource.roles')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label(trans('filament-teams::teams.resource.id')),
                TextColumn::make('name')->sortable()->searchable()->label(trans('filament-teams::teams.resource.name')),
                TextColumn::make('email')->sortable()->searchable()->label(trans('filament-teams::teams.resource.email')),
                BooleanColumn::make('email_verified_at')->sortable()->searchable()->label(trans('filament-teams::teams.resource.email_verified_at')),
                Tables\Columns\TextColumn::make('created_at')->label(trans('filament-teams::teams.resource.created_at'))
                    ->dateTime('M j, Y')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label(trans('filament-teams::teams.resource.updated_at'))
                    ->dateTime('M j, Y')->sortable(),

            ])
            ->prependActions([
                Impersonate::make('impersonate'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label(trans('filament-teams::teams.resource.verified'))
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label(trans('filament-teams::teams.resource.unverified'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
