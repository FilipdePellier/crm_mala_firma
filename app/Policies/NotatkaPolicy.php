<?php

namespace App\Policies;

use App\Models\Notatka;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotatkaPolicy
{
    /**
     * Sprawdza, czy użytkownik może zaktualizować notatkę.
     */
    public function update(User $user, Notatka $notatka): bool
    {
        return $user->id_uzytkownika === $notatka->utworzono_przez;
    }

    /**
     * Sprawdza, czy użytkownik może usunąć notatkę.
     */
    public function delete(User $user, Notatka $notatka): bool
    {
        return $user->id_uzytkownika === $notatka->utworzono_przez;
    }
}