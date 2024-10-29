<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can update the model.
     * Checks if currently logged-in user is the owner of the store associated with the order
     */
    public function update(User $user, Order $order): bool
    {
        //Orders belong to specific stores which then belong to specific user_id
        return $user->id === $order->store->user_id;
    }

}
