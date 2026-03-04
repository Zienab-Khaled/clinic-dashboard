<?php

namespace App\Filament\Resources\Departments\Tables;

use App\Models\Department;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DepartmentsTable
{
    private const TYPE_LABELS = [
        'radiology' => 'الأشعة',
        'pharmacy' => 'الصيدلية',
        'lab' => 'المختبر',
    ];

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('نوع القسم')
                    ->formatStateUsing(fn (string $state): string => self::TYPE_LABELS[$state] ?? $state)
                    ->badge()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('اسم التصنيف')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient_number')
                    ->label('عدد المرضى')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current_serving')
                    ->label('الحالي')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('type')
            ->recordActions([
                Action::make('printTicket')
                    ->label('طباعة تذكرة')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Department $record) => route('department.ticket.show', $record))
                    ->openUrlInNewTab(),
                Action::make('reset')
                    ->label('إعادة تعيين')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('إعادة تعيين هذا التصنيف')
                    ->modalDescription('سيتم تصفير عدد المرضى ورقم الاستدعاء الحالي لهذا التصنيف فقط. هل أنت متأكد؟')
                    ->action(function (Department $record): void {
                        $record->update([
                            'patient_number' => 0,
                            'current_serving' => 0,
                        ]);
                        Notification::make()
                            ->title('تم إعادة تعيين «' . $record->name . '»')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
