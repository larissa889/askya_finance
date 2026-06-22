<?php

namespace App\Modules\Users\Models;

enum UserRole: string
{
    case Admin      = 'admin';
    case Caissier   = 'caissier';
    case Comptable  = 'comptable';
    case Superviseur = 'superviseur';

    /**
     * Human-readable label for each role.
     */
    public function label(): string
    {
        return match($this) {
            self::Admin       => 'Administrateur',
            self::Caissier    => 'Caissier',
            self::Comptable   => 'Comptable',
            self::Superviseur => 'Superviseur',
        };
    }
}
