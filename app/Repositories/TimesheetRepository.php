<?php

namespace App\Repositories;

use App\Models\Timesheet;
use App\Models\User;
use App\Models\Project;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class TimesheetRepository
{
    /**
     * Authenticated User Instance.
     *
     * @var User|null
     */
    public User|null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    /**
     * Get all timesheets for the authenticated user.
     *
     * @return Paginator
     */
    public function getAll(): Paginator
    {
        return $this->user->timesheets()
            ->orderBy('date', 'desc')
            ->with('project')
            ->paginate(10);
    }

    /**
     * Get paginated timesheet data.
     *
     * @param int $perPage
     * @return Paginator
     */
    public function getPaginatedData($perPage = 10): Paginator
    {
        return Timesheet::orderBy('date', 'desc')
            ->with('user', 'project')
            ->paginate($perPage);
    }

    /**
     * Search timesheets by keyword with pagination.
     *
     * @param string $keyword
     * @param int $perPage
     * @return Paginator
     */
    public function searchTimesheets(string $keyword, $perPage = 10): Paginator
    {
        return Timesheet::where('task_name', 'like', '%' . $keyword . '%')
            ->orWhereHas('project', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orderBy('date', 'desc')
            ->with('user', 'project')
            ->paginate($perPage);
    }

    /**
     * Create a new timesheet and assign it to a project.
     *
     * @param array $data
     * @return Timesheet
     */
    public function create(array $data): Timesheet
    {
        $timesheet = Timesheet::create([
            'task_name' => $data['task_name'],
            'date' => $data['date'],
            'hours' => $data['hours'],
            'user_id' => $this->user->id,
            'project_id' => $data['project_id'],
        ]);

        return $timesheet;
    }

    /**
     * Delete a timesheet by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $timesheet = Timesheet::find($id);
        if (empty($timesheet)) {
            return false;
        }

        $timesheet->delete();
        return true;
    }

    /**
     * Get timesheet detail by ID.
     *
     * @param int $id
     * @return Timesheet|null
     */
    public function getByID(int $id): Timesheet|null
    {
        return Timesheet::with('user', 'project')->find($id);
    }

    /**
     * Update timesheet by ID.
     *
     * @param int $id
     * @param array $data
     * @return Timesheet|null
     */
    public function update(int $id, array $data): Timesheet|null
    {
        $timesheet = Timesheet::find($id);

        if (is_null($timesheet)) {
            return null;
        }

        $timesheet->update([
            'task_name' => $data['task_name'],
            'date' => $data['date'],
            'hours' => $data['hours'],
            'project_id' => $data['project_id'],
        ]);

        return $this->getByID($timesheet->id);
    }
}
