<?php

namespace App\Repositories;

use App\Interfaces\DashboardInterface;
use App\Models\User;

class DashboardRepository implements DashboardInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function get_stats_data()
    {
        $firstData = User::count();
        return $firstData;
    }
}
