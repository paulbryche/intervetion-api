<?php

namespace App\Enum;

enum RequestType: string
{
    case PLUMBING = 'PLUMBING';
    case ELECTRICITY = 'ELECTRICITY';
    case CARPENTRY = 'CARPENTRY';
    case OTHER = 'OTHER';

    public function getLabel(): string
    {
        return match ($this) {
            self::PLUMBING => 'Plomberie',
            self::ELECTRICITY => 'Électricité',
            self::CARPENTRY => 'Menuiserie',
            self::OTHER => 'Autre',
        };
    }
}
