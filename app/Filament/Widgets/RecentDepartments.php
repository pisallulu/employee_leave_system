<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Department;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction; // Added for next step suggestion

class RecentDepartments extends TableWidget
{
    protected int | string | array $columnSpan = "full";
    protected static ?int $sort = 1; 
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Department::query()->latest()->limit(5))
            ->columns([
                TextColumn::make("name")->label("Department Name")->color('primary'),
                TextColumn::make("created_at")->label("Created At")->dateTime(),
                TextColumn::make("updated_at")->label("Updated At")->dateTime(),
                TextColumn::make("name")->color('primary'),
                
                
            ])
            ->striped()
            //->hoverIndicator()
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                // You can add an action here, for example:
                //EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
