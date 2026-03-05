<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class Settings extends Page
{
    protected static ?string $navigationLabel = 'الإعدادات';

    protected static ?string $title = 'الإعدادات';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected string $view = 'filament.pages.settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $bg = Setting::getValue('background_image');
        $path = $bg ? \Illuminate\Support\Str::after($bg, 'storage/') : null;
        $this->data = [
            'hospital_name' => Setting::getValue('hospital_name', 'مستشفى الملك عبد العزيز التخصصي بالجوف'),
            'background_image' => $path ? [$path] : [],
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                TextInput::make('hospital_name')
                    ->label('اسم المستشفى')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('background_image')
                    ->label('خلفية الصفحات')
                    ->image()
                    ->disk('public')
                    ->directory('images')
                    ->visibility('public')
                    ->helperText('صورة الخلفية لصفحات الموظف والعرض والتذكرة وغيرها. إن تركت فارغاً تُستخدم الخلفية الافتراضية.'),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ الإعدادات')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make($this->getFormActions())
                    ->alignment(Alignment::Start)
                    ->fullWidth(false)
                    ->sticky(false)
                    ->key('form-actions'),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::setValue('hospital_name', $data['hospital_name'] ?? null);

        $bg = $data['background_image'] ?? null;
        if (is_array($bg)) {
            $bg = $bg[0] ?? null;
        }
        Setting::setValue('background_image', is_string($bg) && $bg !== '' ? 'storage/' . $bg : null);

        Notification::make()
            ->title('تم حفظ الإعدادات')
            ->success()
            ->send();
    }
}
