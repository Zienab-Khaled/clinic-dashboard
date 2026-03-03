<?php

namespace App\Filament\Resources\Clinics\Pages;

use App\Filament\Resources\Clinics\ClinicResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClinic extends EditRecord
{
    protected static string $resource = ClinicResource::class;

    public function getTitle(): string
    {
        return 'تعديل عيادة';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
