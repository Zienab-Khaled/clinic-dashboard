<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use App\Models\Department;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetAll')
                ->label('إعادة تعيين الكل')
                ->color('danger')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->modalHeading('إعادة تعيين كل التصنيفات')
                ->modalDescription('سيتم تصفير عدد المرضى ورقم الاستدعاء لجميع تصنيفات الأشعة والصيدلية والمختبر. هل أنت متأكد؟')
                ->action(function (): void {
                    Department::query()->update([
                        'patient_number' => 0,
                        'current_serving' => 0,
                    ]);
                    Notification::make()
                        ->title('تم إعادة تعيين كل تصنيفات الأقسام')
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
