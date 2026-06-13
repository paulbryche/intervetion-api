<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'USER';
    case ADMIN = 'ADMIN';
    case PLUMBER_TECH = 'PLUMBER_TECH';
    case ELECTRICITY_TECH = 'ELECTRICITY_TECH';

    public function getLabel(): string
    {
        return match ($this) {
            self::USER => 'Client',
            self::ADMIN => 'Administrateur',
            self::PLUMBER_TECH => 'Technicien plomberie',
            self::ELECTRICITY_TECH => 'Technicien électricité',
        };
    }
}
