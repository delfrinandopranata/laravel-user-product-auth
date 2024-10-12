<?php

namespace App\Http\Controllers\Timesheets;

use App\Http\Controllers\Controller; 
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/timesheets",
     *     tags={"Timesheets"},
     *     summary="Get list of timesheets",
     *     description="Get a list of timesheets for the authenticated user",
     *     operationId="getTimesheetsList",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Timesheets fetched successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Timesheets not found"),
     * )
     */
    public function index(): JsonResponse
    {
        $timesheets = Auth::user()->timesheets()->with('project')->get();

        return response()->json([
            'status' => true,
            'message' => 'Timesheets fetched successfully',
            'data' => $timesheets
        ], 200);
    }

    /**
     * @OA\POST(
     *     path="/api/timesheets",
     *     tags={"Timesheets"},
     *     summary="Create a new timesheet",
     *     description="Create a new timesheet and assign it to a project",
     *     operationId="createTimesheet",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="task_name", type="string", example="Task Alpha"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="hours", type="number", format="float", example=8.5),
     *             @OA\Property(property="project_id", type="integer", example=1)
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=201, description="Timesheet created successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Project not found"),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0|max:24',
            'project_id' => 'required|exists:projects,id'
        ]);

        $timesheet = Timesheet::create([
            'task_name' => $validatedData['task_name'],
            'date' => $validatedData['date'],
            'hours' => $validatedData['hours'],
            'user_id' => Auth::id(),
            'project_id' => $validatedData['project_id'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Timesheet logged successfully',
            'data' => $timesheet
        ], 201);
    }

    /**
     * @OA\GET(
     *     path="/api/timesheets/{id}",
     *     tags={"Timesheets"},
     *     summary="Get details of a specific timesheet",
     *     description="Fetches the details of a specific timesheet by its ID",
     *     operationId="getTimesheetById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Timesheet ID"
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Timesheet details fetched successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Timesheet not found"),
     * )
     */
    public function show(Timesheet $timesheet): JsonResponse
    {
        if ($timesheet->user_id !== Auth::id()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access'], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Timesheet fetched successfully',
            'data' => $timesheet->load('project')
        ], 200);
    }

    /**
     * @OA\PUT(
     *     path="/api/timesheets/{id}",
     *     tags={"Timesheets"},
     *     summary="Update an existing timesheet",
     *     description="Update the details of an existing timesheet by its ID",
     *     operationId="updateTimesheetById",
     *     @OA\Parameter(name="id", description="Timesheet ID", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="task_name", type="string", example="Updated Task"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-02-01"),
     *             @OA\Property(property="hours", type="number", format="float", example=7.5),
     *             @OA\Property(property="project_id", type="integer", example=1)
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Timesheet updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Timesheet not found"),
     * )
     */
    public function update(Request $request, Timesheet $timesheet): JsonResponse
    {
        if ($timesheet->user_id !== Auth::id()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access'], 403);
        }

        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0|max:24',
            'project_id' => 'required|exists:projects,id'
        ]);

        $timesheet->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Timesheet updated successfully',
            'data' => $timesheet
        ], 200);
    }

    /**
     * @OA\DELETE(
     *     path="/api/timesheets/{id}",
     *     tags={"Timesheets"},
     *     summary="Delete a timesheet",
     *     description="Delete a timesheet by its ID",
     *     operationId="deleteTimesheetById",
     *     @OA\Parameter(name="id", description="Timesheet ID", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Timesheet deleted successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Timesheet not found"),
     * )
     */
    public function destroy(Timesheet $timesheet): JsonResponse
    {
        if ($timesheet->user_id !== Auth::id()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access'], 403);
        }

        $timesheet->delete();

        return response()->json([
            'status' => true,
            'message' => 'Timesheet deleted successfully'
        ], 200);
    }
}
