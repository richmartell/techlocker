<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view customers list
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        // Users can only view customers from their account
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // All authenticated users can create customers
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        // Users can only update customers from their account
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        // Users can only delete customers from their account
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        // Users can only restore customers from their account
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        // Users can only force delete customers from their account and only in non-production
        return $user->account_id === $customer->account_id && config('app.env') !== 'production';
    }

    /**
     * Determine whether the user can link vehicles to customers.
     */
    public function linkVehicle(User $user, Customer $customer): bool
    {
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can unlink vehicles from customers.
     */
    public function unlinkVehicle(User $user, Customer $customer): bool
    {
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can merge customers.
     */
    public function merge(User $user, Customer $customer): bool
    {
        // Users can only merge customers from their account
        return $user->account_id === $customer->account_id;
    }

    /**
     * Determine whether the user can anonymize customer data.
     */
    public function anonymize(User $user, Customer $customer): bool
    {
        // Users can only anonymize customers from their account
        return $user->account_id === $customer->account_id;
    }
}
