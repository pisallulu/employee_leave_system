<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Carbon\Carbon;
use Filament\Schemas\Components\Section as ComponentsSection;

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make('Request Details')
                    ->schema([
                        // 1. Link to User
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Employee')
                            ->required()
                            ->searchable()
                            ->preload(),

                        // 2. Link to Leave Type
                        Select::make('leave_type_id')
                            ->relationship('leaveType', 'name')
                            ->label('Leave Category')
                            ->required(),

                        

                        // 3. Date Logic (Start)
                        DatePicker::make('start_date')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($get, $set) { // Remove "Get" and "Set" type hints here
                                $start = $get('start_date');
                                $end = $get('end_date');

                                if ($start && $end) {
                                    $days = Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;
                                    $set('total_days', $days);
                                }
                            }),

                        // 3. Date Logic (End) - Do the same here so it updates both ways
                        DatePicker::make('end_date')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($get, $set) {
                                $start = $get('start_date');
                                $end = $get('end_date');

                                if ($start && $end) {
                                    $days = Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;
                                    $set('total_days', $days);
                                }
                            }),
                                                // Read-Only Calculation Field
                        TextInput::make('total_days')
                            ->label('Total Days Requested')
                            ->numeric()
                            ->disabled()
                            ->readonly() // User cannot edit this
                            ->dehydrated(false) // Don't save to DB (calculated on fly)
                            ->prefix('Days'),

                        Textarea::make('reason')
                            ->columnSpanFull(),
                    ])->columns(2),

                ComponentsSection::make('Approval Workflow')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false),
                            
                        Textarea::make('rejection_reason')
                            ->label('Reason for Rejection')
                            ->visible(fn ( $get) => $get('status') === 'rejected')
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }

    // Custom Function to Calculate Dates
    public static function calculateDays( $get,  $set)
    {
        $start = $get('start_date');
        $end = $get('end_date');

        if ($start && $end) {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);

            if ($endDate->gte($startDate)) {
                // inclusive of start date (+1)
                $days = $startDate->diffInDays($endDate) + 1; 
                $set('total_days', $days);
            } else {
                $set('total_days', 'Invalid Range');
            }
        }
    }
}