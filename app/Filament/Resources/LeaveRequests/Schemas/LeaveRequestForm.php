<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Carbon;


use Filament\Schemas\Components\Section;

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Request Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Employee')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('leave_type_id')
                            ->relationship('leaveType', 'name')
                            ->label('Leave Category')
                            ->required(),

                        DatePicker::make('start_date')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateDays($get, $set);
                            }),

                        DatePicker::make('end_date')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateDays($get, $set);
                            }),

                        TextInput::make('total_days')
                            ->label('Total Days Requested')
                            ->numeric()
                            ->readonly()
                            ->dehydrated(false) 
                            ->prefix('Days'),

                        Textarea::make('reason')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Approval Workflow')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false)
                            ->live(), // Added live() so rejection_reason toggles instantly
                            
                        Textarea::make('rejection_reason')
                            ->label('Reason for Rejection')
                            ->visible(fn (Get $get) => $get('status') === 'rejected')
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }

    // Fixed the "et$set" typos here
    public static function calculateDays(Get $get, Set $set): void
{
    $start = $get('start_date');
    $end = $get('end_date');

    if ($start && $end) {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        if ($endDate->gte($startDate)) {
            // +1 includes the end day in the count
            $days = $startDate->diffInDays($endDate) + 1; 
            $set('total_days', $days);
        } else {
            $set('total_days', 'Invalid Range');
        }
    }
}

}