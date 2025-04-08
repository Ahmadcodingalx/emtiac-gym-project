<?php

namespace App\Repositories;

use App\Interfaces\ExportsInterface;
use App\Models\Abonnement;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ExportsRepository implements ExportsInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function exportBilanPdf($month)
    {
        // 🔹 Requête pour récupérer les données
        $incomeQuery = DB::table('incomes')
            ->selectRaw("
                incomes.amount AS amount,
                incomes.reason AS reason,
                'income' AS type,
                incomes.date AS date
            ")
            ->whereMonth('date', $month)
            ->join('users', 'users.id', '=', 'incomes.user_id');

        $expensesQuery = DB::table('expenses')
            ->selectRaw("
                expenses.amount AS amount,
                expenses.reason AS reason,
                'expense' AS type,
                expenses.date AS date
            ")
            ->whereMonth('date', $month)
            ->join('users', 'users.id', '=', 'expenses.user_id');


        $transactions = DB::table(DB::raw("({$incomeQuery->toSql()} UNION ALL {$expensesQuery->toSql()}) as transactions"))
            ->mergeBindings($incomeQuery)
            ->mergeBindings($expensesQuery)
            ->orderBy('transactions.date', 'desc')
            ->get();
        
        $incomes = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');

        $data = [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'transactions' => $transactions
        ];
        
        return $data;
    }

    public function exportRestPayPdf($month)
    {
        $rest = Abonnement::where('rest', '>', 0)
                            ->with('client')
                            ->whereMonth('created_at', $month)
                            ->get();
        return $rest;
    }
}
