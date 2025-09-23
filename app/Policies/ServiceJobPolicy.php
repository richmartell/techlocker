<?php

namespace App\Policies;

use App\Models\VehicleJob;
use App\Models\User;

class VehicleJobPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, VehicleJob $job): bool
    {
        return $user->account_id === $job->account_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, VehicleJob $job): bool
    {
        return $user->account_id === $job->account_id;
    }

    public function delete(User $user, VehicleJob $job): bool
    {
        return $user->account_id === $job->account_id;
    }
}
