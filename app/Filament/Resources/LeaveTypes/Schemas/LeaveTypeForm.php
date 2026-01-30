<?php

namespace App\Filament\Resources\LeaveTypes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Section;
// use Filament\Schemas\Components\Section as ComponentsSection;

class LeaveTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Leave Type Configuration')
                    ->description('Set the name and annual day limit for this category.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Leave Category Name')
                            ->placeholder('e.g., Annual Leave, Sick Leave')
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'leave_types', column: 'name', ignoreRecord: true),

                        TextInput::make('limit_days')
                            ->label('Yearly Limit (Days)')
                            ->numeric()
                            ->default(10)
                            ->minValue(1)
                            ->required()
                            ->suffix('Days'),
                    ])->columns(2),
            ]);
    }
}