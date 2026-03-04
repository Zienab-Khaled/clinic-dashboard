<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Settings extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationLabel = 'الإعدادات';

    protected static ?string $title = 'الإعدادات';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected string $view = 'filament.pages.settings';
}
