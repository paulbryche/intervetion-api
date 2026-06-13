<?php

namespace App\Enum;

enum RequestStatus: string
{
    case PENDING = 'PENDING';
    case ASSIGNED = 'ASSIGNED';
    case CLOSED = 'CLOSED';
    case REJECTED = 'REJECTED';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::ASSIGNED => 'Assignée',
            self::CLOSED => 'Clôturée',
            self::REJECTED => 'Rejetée',
        };
    }
}
