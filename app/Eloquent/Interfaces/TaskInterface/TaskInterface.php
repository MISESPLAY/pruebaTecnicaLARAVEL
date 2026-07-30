<?php

namespace App\Eloquent\Interfaces\TaskInterface;

use App\Eloquent\Entity\Task;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Collection;

interface TaskInterface
{
    public function all(?TaskStatus $status = null): Collection;

    public function createTask(string $title, ?string $description = null, TaskStatus $status = TaskStatus::Pending): Task;

    public function find(int $id): ?Task;

    public function updateTask(Task $task, array $data): Task;

    public function deleteTask(Task $task): bool;
}
