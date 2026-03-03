<?php

namespace App\Filament\Resources\Clinics\Pages;

use App\Filament\Resources\Clinics\ClinicResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClinic extends CreateRecord
{
    protected static string $resource = ClinicResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_at'] = now();
        $data['patient_number'] = 0;

        return $data;
    }

    public function getTitle(): string
    {
        return 'إضافة عيادة';
    }
}
