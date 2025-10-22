<?php

namespace App\Policies;

use App\Models\Caso;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization; 

class CasoPolicy
{
    use HandlesAuthorization; 

   
    public function viewAny(User $user): bool
    {
        return $user->isAbogada(); 
    }

  
    public function view(User $user, Caso $caso): bool
    {
        return $user->id === $caso->usuario_id;
    }

  
    public function create(User $user): bool
    {
        return $user->isAbogada();
    }


    public function update(User $user, Caso $caso): bool
    {
        return $user->id === $caso->usuario_id;
    }


    public function delete(User $user, Caso $caso): bool
    {
        return $user->id === $caso->usuario_id;
    }
}