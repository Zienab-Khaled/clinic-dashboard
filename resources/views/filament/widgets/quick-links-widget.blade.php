<x-filament-widgets::widget class="fi-quick-links-widget">
    <x-filament::section>
        <x-slot name="heading">
            روابط سريعة
        </x-slot>

        <div class="flex flex-wrap gap-3" dir="rtl">
            <x-filament::button
                tag="a"
                href="{{ route('home') }}"
                target="_blank"
                color="primary"
                icon="heroicon-o-home"
            >
                الصفحة الرئيسية
            </x-filament::button>
            <x-filament::button
                tag="a"
                href="{{ route('staff') }}"
                target="_blank"
                color="gray"
                icon="heroicon-o-ticket"
            >
                شاشة الموظف (العيادات)
            </x-filament::button>
            <x-filament::button
                tag="a"
                href="{{ route('display') }}"
                target="_blank"
                color="gray"
                icon="heroicon-o-rectangle-group"
            >
                شاشة الانتظار (العرض)
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
