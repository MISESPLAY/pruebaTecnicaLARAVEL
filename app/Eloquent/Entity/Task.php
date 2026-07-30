<?php

namespace App\Eloquent\Entity;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];
}
