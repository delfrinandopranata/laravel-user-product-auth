<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ProjectRepository
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
     * Get all projects for the authenticated user.
     *
     * @return Paginator
     */
    public function getAll(): Paginator
    {
        return $this->user->projects()
            ->orderBy('id', 'desc')
            ->with('users')
            ->paginate(10);
    }

    /**
     * Get paginated project data.
     *
     * @param int $perPage
     * @return Paginator
     */
    public function getPaginatedData($perPage = 10): Paginator
    {
        return Project::orderBy('id', 'desc')
            ->with('users')
            ->paginate($perPage);
    }

    /**
     * Search projects by keyword with pagination.
     *
     * @param string $keyword
     * @param int $perPage
     * @return Paginator
     */
    public function searchProjects(string $keyword, $perPage = 10): Paginator
    {
        return Project::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('department', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('users')
            ->paginate($perPage);
    }

    /**
     * Create a new project and assign users.
     *
     * @param array $data
     * @return Project
     */
    public function create(array $data): Project
    {
        $project = Project::create($data);
        $project->users()->sync($data['user_ids']);
        return $project;
    }

    /**
     * Delete a project by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $project = Project::find($id);
        if (empty($project)) {
            return false;
        }

        $project->delete();
        return true;
    }

    /**
     * Get project detail by ID.
     *
     * @param int $id
     * @return Project|null
     */
    public function getByID(int $id): Project|null
    {
        return Project::with('users')->find($id);
    }

    /**
     * Update project by ID and assign users.
     *
     * @param int $id
     * @param array $data
     * @return Project|null
     */
    public function update(int $id, array $data): Project|null
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return null;
        }

        $project->update($data);
        $project->users()->sync($data['user_ids']);

        return $this->getByID($project->id);
    }
}
