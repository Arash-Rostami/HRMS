<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Admin
{
    /**
     * @return Select
     */
    public static function getModel(): Select
    {
        return Select::make('model')
            ->label('Module')
            ->required()
            ->options(function () {
                $models = collect(File::files(app_path('Models')))
                    ->map(fn($file) => pathinfo($file)['filename'])
                    ->filter(function ($modelName) {
                        $modelClass =  "App\\Models\\{$modelName}";
                        return !property_exists($modelClass, 'filamentDetection') || $modelClass::$filamentDetection !== false;
                    })
                    ->toArray();
                return array_combine($models, $models);
            })
            ->hidden(fn(Closure $get) => $get('role') == 'developer')
            ->reactive();
    }

    /**
     * @return Select
     */
    public static function getPermission(): Select
    {
        return Select::make('permission')
            ->label('Access level')
            ->required()
            ->options([
                'all' => 'All',
                'view' => 'View',
                'create' => 'Create',
                'edit' => 'Edit',
                'delete' => 'Delete',
            ])
            ->hidden(fn(Closure $get) => $get('role') == 'developer')
            ->reactive();
    }

    /**
     * @return Select
     */
    public static function getRole(): Select
    {
        return Select::make('role')
            ->options([
                'admin' => 'Admin',
                'developer' => 'Super Admin',
            ])
            ->afterStateHydrated(function (Closure $set, $state) {
                $set('permission', 'all');
                $set('model', 'All');
            });
    }

    /**
     * @return Select
     */
    public static function getUser(): Select
    {
        return Select::make('user_id')
            ->label('User')
            ->required()
            ->autofocus()
            ->relationship('user', 'id', fn(Builder $query) => $query->where('forename', 'not like', 'Guest%')->where('status','active')->orderBy('surname')->orderBy('forename'))
            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->surname}, {$record->forename} ");
    }

    public static function modifyUser(array $data): array
    {
        $user = User::find($data['user_id']);
        $user->role = $data['role'];
        $user->save();

        $data['model'] = $data['model'] ?? 'All';
        $data['permission'] = $data['permission'] ?? 'all';

        return $data;
    }

    /**
     * @return TextColumn
     */
    public static function showUser(): TextColumn
    {
        return TextColumn::make('user.full_name')
            ->color('secondary')
            ->toggleable()
            ->sortable(['forename'])
            ->searchable(['forename', 'surname'])
            ->label('Administrator');
    }

    /**
     * @return BadgeColumn
     */
    public static function showModel(): BadgeColumn
    {
        return BadgeColumn::make('model')
            ->label('Module')
            ->color('primary')
            ->sortable()
            ->searchable()
            ->toggleable();
    }

    /**
     * @return BadgeColumn
     */
    public static function showPermission(): BadgeColumn
    {
        return BadgeColumn::make('permission')
            ->toggleable()
            ->sortable()
            ->searchable()
            ->formatStateUsing(fn(string $state): string => ucfirst($state));
    }

    /**
     * @return IconColumn
     */
    public static function showRole(): IconColumn
    {
        return IconColumn::make('user.role')
            ->label('Role')
            ->options([
                'heroicon-o-shield-check' => 'admin',
                'heroicon-o-code' => 'developer',
            ])
            ->colors([
                'success' => 'developer',
                'primary' => 'admin',
            ]);
    }
}
