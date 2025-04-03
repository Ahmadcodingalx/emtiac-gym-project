<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function transList($request);
    public function store($data, $type);
    public function getAbb();
    public function getSale();
    public function getRest();
    public function getDailyIncome();
    public function getWeeklyIncome();
    public function getMonthlyIncome();
    public function getYearlyIncome();
    public function getDailyExpense();
    public function getWeeklyExpense();
    public function getMonthlyExpense();
    public function getYearlyExpense();
}
