<?php

namespace App\Policies;

use App\Models\User;

class FundPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete()
    {
        return true;
    }
}
