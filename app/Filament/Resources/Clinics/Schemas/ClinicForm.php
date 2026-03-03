<?php

namespace App\Filament\Resources\Clinics\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClinicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم العيادة')
                    ->required(),
            ]);
    }
}
