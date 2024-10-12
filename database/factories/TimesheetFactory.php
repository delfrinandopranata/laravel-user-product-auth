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
        // Ensure at least one user and one project exist
        $user = User::first(); // Retrieve the first available user
        $project = Project::first(); // Retrieve the first available project

        if ($user && $project) {
            // Create a timesheet for an existing user and project
            Timesheet::create([
                'task_name' => 'Initial Task',
                'date' => '2024-01-01',
                'hours' => 8,
                'user_id' => $user->id,  // Valid user ID
                'project_id' => $project->id,  // Valid project ID
            ]);
        } else {
            // Handle error if no users or projects exist
            $this->command->error('No users or projects available for timesheets.');
        }
    }
}
