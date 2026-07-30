<?php

namespace App\Http\Controllers;

use App\Eloquent\Interfaces\TaskInterface\TaskInterface;
use App\Enums\TaskStatus;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function __construct(private readonly TaskInterface $tasks) {}

    public function get(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['sometimes', 'required', Rule::enum(TaskStatus::class)],
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->tasks->all(isset($validated['status']) ? TaskStatus::from($validated['status']) : null),
        ]);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = $this->tasks->createTask(
            title: $request->validated('title'),
            description: $request->validated('description'),
            status: TaskStatus::from($request->validated('status', TaskStatus::Pending->value)),
        );

        return response()->json([
            'success' => true,
            'message' => 'Tarea creada correctamente.',
            'data' => $task,
        ], 201);
    }

    public function update(TaskRequest $request, int $id): JsonResponse
    {
        $task = $this->tasks->find($id);

        if (! $task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea actualizada correctamente.',
            'data' => $this->tasks->updateTask($task, $this->validatedData($request)),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $task = $this->tasks->find($id);

        if (! $task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada.',
            ], 404);
        }

        return response()->json([
            'success' => $this->tasks->deleteTask($task),
            'message' => 'Tarea eliminada correctamente.',
        ]);
    }

    /**
     * @return array{title?: string, description?: string|null, status?: TaskStatus}
     */
    private function validatedData(TaskRequest $request): array
    {
        $data = $request->validated();

        if (isset($data['status'])) {
            $data['status'] = TaskStatus::from($data['status']);
        }

        return $data;
    }
}
