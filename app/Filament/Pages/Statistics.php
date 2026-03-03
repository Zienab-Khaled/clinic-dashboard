<?php

namespace App\Filament\Pages;

use App\Models\Clinic;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class Statistics extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'الإحصائيات';

    protected static ?string $title = 'الإحصائيات';

    protected static ?int $navigationSort = 2;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBarSquare;

    protected string $view = 'filament.pages.statistics';

    public function mount(): void
    {
        $this->mountInteractsWithTable();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                EmbeddedTable::make(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم العيادة')
                    ->searchable(),
                TextColumn::make('patient_number')
                    ->label('عدد المرضى')
                    ->numeric()
                    ->sortable(),
            ])
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(25)
            ->striped();
    }

    protected function getTableQuery(): ?Builder
    {
        return Clinic::query()->orderBy('name');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reset')
                ->label('إعادة تعيين الإحصائيات')
                ->color('danger')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->modalHeading('إعادة تعيين أرقام المرضى')
                ->modalDescription('سيتم تصفير عدد المرضى لجميع العيادات. هل أنت متأكد؟')
                ->action(function (): void {
                    Clinic::query()->update(['patient_number' => 0]);
                    Notification::make()
                        ->title('تم تصفير الإحصائيات')
                        ->success()
                        ->send();
                }),
            Action::make('print')
                ->label('طباعة التقرير')
                ->icon('heroicon-o-printer')
                ->url(route('admin.statistics.print'))
                ->openUrlInNewTab(),
        ];
    }
}
