<?php

namespace App\Enums;

enum Status :string
{
    case Pending = 'pending';
    case Active = 'active';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public function isCompleted(): bool
    {
        return $this === self::Completed;
    }

}
