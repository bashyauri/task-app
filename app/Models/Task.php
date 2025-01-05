<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    public const NOT_STARTED = 0;
    public const PENDING = 1;
    public const IN_PROGRESS = 2;
    public const COMPLETED = 3;
    protected $guarded = [];
    public function taskMembers(): HasMany
    {
        return $this->hasMany(TaskMember::class);
    }
    public static function changeTaskStatus($taskId, $status)
    {
        Task::where('id', $taskId)->update(['status' => $status]);
    }
}
