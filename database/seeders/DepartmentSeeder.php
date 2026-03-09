<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['type' => 'emergency', 'name' => 'طوارئ رجال'],
            ['type' => 'emergency', 'name' => 'طوارئ نساء'],
            ['type' => 'radiology', 'name' => 'XR'],
            ['type' => 'radiology', 'name' => 'CT'],
            ['type' => 'radiology', 'name' => 'MR'],
            ['type' => 'radiology', 'name' => 'US'],
            ['type' => 'radiology', 'name' => 'FL'],
            ['type' => 'radiology', 'name' => 'MA'],
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
