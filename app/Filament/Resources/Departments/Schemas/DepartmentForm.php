<?php

namespace App\Filament\Resources\Departments\Schemas;

use App\Models\Service;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        $departmentTypeOptions = Service::query()
            ->whereNull('parent_id')
            ->where('active', true)
            ->where('key', '!=', 'clinics')
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(fn (Service $s) => [
                $s->key => $s->title . ' — ' . Str::title(str_replace(['-', '_'], ' ', $s->key)),
            ])
            ->all();

        return $schema
            ->components([
                Select::make('type')
                    ->label('نوع القسم')
                    ->options($departmentTypeOptions)
                    ->required()
                    ->native(false)
                    ->searchable(),
                TextInput::make('name')
                    ->label('الاسم (عربي)')
                    ->required()
                    ->placeholder('مثال: أشعة عادية، مختبر رجال'),
                TextInput::make('name_en')
                    ->label('الاسم (إنجليزي)')
                    ->placeholder('مثال: Regular X-Ray, Men\'s Lab'),
            ]);
    }
}
