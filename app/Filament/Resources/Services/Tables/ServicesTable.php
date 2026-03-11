<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parent.title')
                    ->label('الأب')
                    ->placeholder('—'),
                TextColumn::make('title')
                    ->label('الاسم (عربي)')
                    ->searchable(),
                TextColumn::make('key')
                    ->label('الاسم (إنجليزي)'),
                IconColumn::make('has_waiting_display')
                    ->label('شاشة انتظار / استدعاء')
                    ->boolean(),
                TextColumn::make('subtitle')
                    ->label('الوصف')
                    ->limit(40),
                TextColumn::make('route_name')
                    ->label('Route'),
                TextColumn::make('route_params')
                    ->label('Params')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }

                        if (is_string($state)) {
                            return $state;
                        }

                        return json_encode($state, JSON_UNESCAPED_UNICODE);
                    }),
                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
                IconColumn::make('active')
                    ->label('مفعل')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                Action::make('openLink')
                    ->label('فتح اللينك')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Service $record) => $record->url)
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

