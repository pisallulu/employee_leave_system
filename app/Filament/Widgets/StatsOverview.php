<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Models\Department;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatsOverview extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [
            Stat::make('Total Departments', Department::count(
                
            ))
                ->description('All Departments')
                ->color('primary')
                ->icon('heroicon-o-building-office-2'),
            Stat::make('Total Employee', User::where('role', 'employee')->count())
                ->description('All Employees')
                ->color('primary')
                ->icon('heroicon-o-users'),
        ];

    }
    protected function getColumns(): int
    {
        return 2;
    
    }
}
