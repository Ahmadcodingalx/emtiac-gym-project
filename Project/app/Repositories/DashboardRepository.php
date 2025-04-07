<?php

namespace App\Repositories;

use App\Interfaces\DashboardInterface;
use App\Models\Client;
use App\Models\Expenses;
use App\Models\Income;
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

    public function get_user_data()
    {
        $user = User::count();
        return $user;
    }

    public function get_client_data()
    {
        $client = Client::count();
        return $client;
    }

    public function get_income_data()
    {
        $income = Income::all()->sum('amount');
        return $income;
    }

    public function get_expense_data()
    {
        $expenses = Expenses::all()->sum('amount');
        return $expenses;
    }

    public function get_sale_income_data()
    {
        $sale = Income::where('type', 'sale')->sum('amount');
        return $sale;
    }
}
