<?php

namespace App\Eloquent\Repository;

use App\Eloquent\Entity\Task;
use App\Eloquent\Interfaces\TaskInterface\TaskInterface;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskInterface
{
    public function all(?TaskStatus $status = null): Collection
    {
        return Task::query()
            ->when($status, fn ($query) => $query->where('status', $status->value))
            ->latest()
            ->get();
    }

    public function createTask(string $title, ?string $description = null, TaskStatus $status = TaskStatus::Pending): Task
    {
        return Task::create([
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);
    }

    public function find(int $id): ?Task
    {
        return Task::find($id);
    }

    /**
     * @param  array{title?: string, description?: string|null, status?: TaskStatus}  $data
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);

        return $task->refresh();
    }

    public function deleteTask(Task $task): bool
    {
        return (bool) $task->delete();
    }
}
