<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DepartmentStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Departments', Department::count())
                ->description('All recorded departments')
                ->color('info')
                ->icon('heroicon-o-building-office-2'),
        ];
    }
}
