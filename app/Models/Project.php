<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $guarded = [];
    public function taskProgress(): HasOne
    {
        return $this->hasOne(related: TaskProgress::class);
    }
}
