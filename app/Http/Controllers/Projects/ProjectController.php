<?php

namespace App\Http\Controllers\Projects;

use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *     description="API Authentication for User Project Timesheet by Delfrinando",
 *     version="1.0.0",
 *     title="User Project Timesheet API Documentation",
 *     @OA\Contact(
 *         email="delfrinando@gmail.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */


class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->projectRepository = $projectRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Get Project List",
     *     description="Get a list of projects assigned to the authenticated user",
     *     operationId="getProjectsList",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="perPage", description="Number of projects per page", example=10, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Get Project List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $projects = $this->projectRepository->getAll();
            return response()->json([
                'status' => true,
                'message' => 'Projects fetched successfully',
                'data' => $projects
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Create a new project",
     *     description="Create a new project and assign it to users",
     *     operationId="createProject",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Project Alpha"),
     *             @OA\Property(property="department", type="string", example="Engineering"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="status", type="string", example="in_progress"),
     *             @OA\Property(property="user_ids", type="array", @OA\Items(type="integer"), example={1, 2, 3})
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=201, description="Project created successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $project = $this->projectRepository->create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    }

    /**
     * @OA\GET(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Get Project Details",
     *     description="Get details of a specific project by its ID",
     *     operationId="getProjectById",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="Project ID", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Project details fetched successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Project not found"),
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $project = $this->projectRepository->getByID($id);

            if (!$project) {
                return response()->json([
                    'status' => false,
                    'message' => 'Project not found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Project details fetched successfully',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Update Project",
     *     description="Update an existing project",
     *     operationId="updateProjectById",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="Project ID", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Updated Project"),
     *             @OA\Property(property="department", type="string", example="HR"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-02-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="status", type="string", example="completed"),
     *             @OA\Property(property="user_ids", type="array", @OA\Items(type="integer"), example={1, 2, 3})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Project updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Project not found"),
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $project = $this->projectRepository->update($id, $validatedData);

        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Project updated successfully',
            'data' => $project
        ], 200);
    }

    /**
     * @OA\DELETE(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Delete Project",
     *     description="Delete a project by ID",
     *     operationId="deleteProjectById",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="Project ID", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Project deleted successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Project not found"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->projectRepository->delete($id);

            if (!$deleted) {
                return response()->json([
                    'status' => false,
                    'message' => 'Project not found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Project deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
