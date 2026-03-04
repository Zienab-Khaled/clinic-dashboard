<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['type' => 'radiology', 'name' => 'أشعة عادية'],
            ['type' => 'radiology', 'name' => 'أشعة مقطعية'],
            ['type' => 'pharmacy', 'name' => 'الصيدلية'],
            ['type' => 'lab', 'name' => 'مختبر رجال'],
            ['type' => 'lab', 'name' => 'مختبر نساء'],
        ];

        foreach ($items as $item) {
            Department::firstOrCreate(
                ['type' => $item['type'], 'name' => $item['name']],
                ['patient_number' => 0, 'current_serving' => 0]
            );
        }
    }
}
