<?php

namespace App\Policies;

use App\Models\Technician;
use App\Models\User;

class TechnicianPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Technician $tech): bool
    {
        return $user->account_id === $tech->account_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Technician $tech): bool
    {
        return $user->account_id === $tech->account_id;
    }

    public function delete(User $user, Technician $tech): bool
    {
        return $user->account_id === $tech->account_id;
    }
}
