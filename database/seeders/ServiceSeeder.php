<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'key' => 'clinics',
                'title' => 'العيادات',
                'subtitle' => 'إصدار تذاكر العيادات',
                'icon' => '🏥',
                'route_name' => 'staff',
                'route_params' => [],
                'card_class' => 'card-main rounded-2xl border-2 border-amber-400 bg-amber-50 hover:bg-amber-100 p-8 shadow-lg text-center block',
                'sort_order' => 1,
                'parent_id' => null,
                'active' => true,
                'has_waiting_display' => true,
            ],
            [
                'key' => 'diabetes',
                'title' => 'عيادات السكر',
                'subtitle' => 'إصدار تذاكر عيادات السكر',
                'icon' => '🩺',
                'route_name' => 'department.staff',
                'route_params' => ['type' => 'diabetes'],
                'card_class' => 'card-main rounded-2xl border-2 border-orange-400 bg-orange-50 hover:bg-orange-100 p-8 shadow-lg text-center block',
                'sort_order' => 2,
                'parent_id' => null,
                'active' => true,
                'has_waiting_display' => false,
            ],
            [
                'key' => 'emergency',
                'title' => 'الطوارئ',
                'subtitle' => 'أقسام الطوارئ — إصدار تذاكر',
                'icon' => '🚑',
                'route_name' => 'department.staff',
                'route_params' => ['type' => 'emergency'],
                'card_class' => 'card-main rounded-2xl border-2 border-red-400 bg-red-50 hover:bg-red-100 p-8 shadow-lg text-center block',
                'sort_order' => 3,
                'parent_id' => null,
                'active' => true,
                'has_waiting_display' => false,
            ],
            [
                'key' => 'radiology',
                'title' => 'الأشعة',
                'subtitle' => 'إصدار تذاكر الأشعة',
                'icon' => '📷',
                'route_name' => 'department.staff',
                'route_params' => ['type' => 'radiology'],
                'card_class' => 'card-main rounded-2xl border-2 border-sky-400 bg-sky-50 hover:bg-sky-100 p-8 shadow-lg text-center block',
                'sort_order' => 4,
                'parent_id' => null,
                'active' => true,
                'has_waiting_display' => false,
            ],
            [
                'key' => 'pharmacy',
                'title' => 'الصيدلية',
                'subtitle' => 'إصدار تذاكر الصيدلية',
                'icon' => '💊',
                'route_name' => 'department.staff',
                'route_params' => ['type' => 'pharmacy'],
                'card_class' => 'card-main rounded-2xl border-2 border-emerald-400 bg-emerald-50 hover:bg-emerald-100 p-8 shadow-lg text-center block',
                'sort_order' => 5,
                'parent_id' => null,
                'active' => true,
                'has_waiting_display' => false,
            ],
            [
                'key' => 'lab',
                'title' => 'المختبر',
                'subtitle' => 'إصدار تذاكر المختبر',
                'icon' => '🔬',
                'route_name' => 'department.staff',
                'route_params' => ['type' => 'lab'],
                'card_class' => 'card-main rounded-2xl border-2 border-violet-400 bg-violet-50 hover:bg-violet-100 p-8 shadow-lg text-center block',
                'sort_order' => 6,
                'parent_id' => null,
                'active' => true,
                'has_waiting_display' => false,
            ],
        ];

        foreach ($items as $item) {
            Service::updateOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
