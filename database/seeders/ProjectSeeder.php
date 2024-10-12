<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing projects
        DB::table('projects')->delete();

        // Insert a specific project
        $data = [
            'name' => 'Initial Project',
            'department' => 'Engineering',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'status' => 'in_progress',
        ];
        Project::create($data);

        // Testing Dummy Projects with factory
        Project::factory(10)->create();
    }
}
