<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('نوع القسم')
                    ->options([
                        'radiology' => 'الأشعة',
                        'pharmacy' => 'الصيدلية',
                        'lab' => 'المختبر',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('name')
                    ->label('اسم التصنيف')
                    ->required()
                    ->placeholder('مثال: أشعة عادية، مختبر رجال'),
            ]);
    }
}
