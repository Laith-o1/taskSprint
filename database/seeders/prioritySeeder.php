<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Priority;

class prioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create priorities 
        $priorities = [
            [
                'name' => 'Low',
                // 'description' => 'Low priority',
            ],
            [
                'name' => 'Medium',
                // 'description' => 'Medium priority',
            ],
            // [
            //     'name' => 'Normal',
            // ],
            [
                'name' => 'High',
                // 'description' => 'High priority',
            ],
        ];
        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
