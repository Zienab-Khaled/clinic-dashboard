<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        $defaultCardClass = 'card-main rounded-2xl border-2 border-slate-400 bg-slate-50 hover:bg-slate-100 p-8 shadow-lg text-center block';

        return $schema
            ->components([
                TextInput::make('title')
                    ->label('الاسم (عربي)')
                    ->required(),
                TextInput::make('key')
                    ->label('الاسم (إنجليزي)')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('subtitle')
                    ->label('الوصف')
                    ->placeholder('اختياري: يظهر تحت اسم القسم على الصفحة')
                    ->helperText('إن تركت فارغاً سيظهر تلقائياً: إصدار تذاكر + اسم القسم'),
                Toggle::make('has_waiting_display')
                    ->label('شاشة عرض انتظار وتحديث الأدوار (طلب استدعاء)')
                    ->helperText('تفعيل إن كان لهذه الخدمة شاشة عرض انتظار وطلب استدعاء')
                    ->default(false),
                Hidden::make('parent_id')->default(null),
                Hidden::make('icon')->default('🎫'),
                Hidden::make('route_name')->default('staff'),
                Hidden::make('route_params')->default([]),
                Hidden::make('card_class')->default($defaultCardClass),
                Hidden::make('sort_order')->default(0),
                Hidden::make('active')->default(true),
            ]);
    }
}
