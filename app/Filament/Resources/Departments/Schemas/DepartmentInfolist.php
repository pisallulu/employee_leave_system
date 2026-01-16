<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section; // The correct v4 namespace
use Filament\Infolists\Components\TextEntry;

class DepartmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Department Details')
                    ->schema([
                        TextEntry::make('name')
                            ->columnSpanFull()
                            ->label('Department'),

                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                            
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(4), // Aligns timestamps side-by-side
            ]);
    }
}
