<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Project;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve first available user and project
        $user = User::first();
        $project = Project::first();

        if (!$user || !$project) {
            $this->command->info('No users or projects available for timesheets.');
            return; // Exit if no user or project is found
        }

        $this->command->info("Using User ID: {$user->id} and Project ID: {$project->id}");

        // Create a timesheet for an existing user and project
        Timesheet::create([
            'task_name' => 'Initial Task',
            'date' => '2024-01-01',
            'hours' => 8,
            'user_id' => $user->id,  // Valid user ID
            'project_id' => $project->id,  // Valid project ID
        ]);
    }
}
