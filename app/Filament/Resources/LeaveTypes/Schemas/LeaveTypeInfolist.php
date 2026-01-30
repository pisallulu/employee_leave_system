<?php

namespace App\Filament\Resources\LeaveTypes\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
// use Filament\Infolists\Components\Section;
// use Filament\Infolists\Section;
// use Filament\Schemas\Components\Section as ComponentsSection;

class LeaveTypeInfolist 
{
    
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Leave Type Overview')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Category Name')
                            ->weight('bold')
                            ->color('primary'),

                        TextEntry::make('limit_days')
                            ->label('Annual Allowance')
                            ->suffix(' Days')
                            ->badge()
                            ->color('success'),

                        TextEntry::make('created_at')
                            ->label('System Entry Date')
                            ->dateTime('d M Y'),
                    ])->columns(3), 
            ]);
    }
}