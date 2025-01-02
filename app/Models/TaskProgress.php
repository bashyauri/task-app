<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskProgress extends Model
{
    public const NOT_PINNED_ON_DASHBOARD = 0;
    public const PINNED_ON_DASHBOARD = 1;
    public const INITIAL_PROJECT_PERCENTAGE = 0;
    protected $guarded = [];
}
