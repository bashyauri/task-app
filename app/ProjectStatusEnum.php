<?php

namespace App;

enum ProjectStatusEnum: int
{
    case NotStarted = 0;
    case Pending = 1;
    case InProgress = 2;
    case Completed = 3;
    case Cancelled = 4;

    public function getStatus(): string
    {
        return match ($this) {
            self::NotStarted => 'Not Started',
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }
}