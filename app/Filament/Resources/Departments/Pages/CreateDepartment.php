<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['patient_number'] = $data['patient_number'] ?? 0;
        $data['current_serving'] = $data['current_serving'] ?? 0;

        return $data;
    }

    public function getTitle(): string
    {
        return 'إضافة تصنيف (أشعة / صيدلية / مختبر)';
    }
}
