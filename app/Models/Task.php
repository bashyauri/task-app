<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public const NOT_STARTED = 0;
    public const PENDING = 1;
    public const IN_PROGRESS = 2;
    public const COMPLETED = 3;
    protected $guarded = [];
}
