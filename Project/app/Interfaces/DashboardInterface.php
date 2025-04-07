<?php

namespace App\Interfaces;

interface DashboardInterface
{
    //
    public function get_user_data();
    public function get_client_data();
    public function get_income_data();
    public function get_expense_data();
    public function get_sale_income_data();
}
