<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\Abonnement;
use App\Models\Expenses;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function transList($request)
    {

        $search = $request->input('search');
        $type = $request->input('type');

        // $transactions = DB::query()->fromSub(
        //     Income::select('id', 'user_id', 'date', 'amount', 'reason', DB::raw("'income' as type"))
        //         ->union(
        //             Expenses::select('id', 'user_id', 'date', 'amount', 'reason', DB::raw("'expense' as type"))
        //         ),
        //     'transactions'
        // )->orderBy('date', 'desc');
        // Création d'une requête pour Income

        // $incomeQuery = Income::query()->select('id', 'user_id', 'date', 'amount', 'reason', DB::raw("'income' as type"));

        // // Création d'une requête pour Expenses
        // $expensesQuery = Expenses::query()->select('id', 'user_id', 'date', 'amount', 'reason', DB::raw("'expense' as type"));

        // // Union des deux requêtes
        // $transactions = DB::query()->fromSub(
        //     $incomeQuery->union($expensesQuery),
        //     'transactions'
        // )->orderBy('date', 'desc');

        // Sous-requête pour les revenus (income)
        $incomeQuery = Income::query()
            ->select(
                'incomes.id',
                'incomes.user_id',
                'incomes.date',
                'incomes.amount',
                'incomes.reason',
                DB::raw("'income' as type"),
                'users.firstname as firstname', // Ajout du nom de l'utilisateur
                'users.lastname as lastname' // Ajout du nom de l'utilisateur
            )
            ->join('users', 'users.id', '=', 'incomes.user_id');

        // Sous-requête pour les dépenses (expense)
        $expensesQuery = Expenses::query()
            ->select(
                'expenses.id',
                'expenses.user_id',
                'expenses.date',
                'expenses.amount',
                'expenses.reason',
                DB::raw("'expense' as type"),
                'users.firstname as firstname', // Ajout du nom de l'utilisateur
                'users.lastname as lastname' // Ajout du nom de l'utilisateur
            )
            ->join('users', 'users.id', '=', 'expenses.user_id');

        // Union des deux requêtes
        $transactions = DB::table(DB::raw("({$incomeQuery->toSql()} UNION {$expensesQuery->toSql()}) as transactions"))
            ->mergeBindings($incomeQuery->getQuery())
            ->mergeBindings($expensesQuery->getQuery())
            ->orderBy('date', 'desc');

        // Filtrer par type (Entrées = income / Sorties = expense)
        if ($type == 'Entrées') {
            $transactions->where('type', 'income');
        } elseif ($type == 'Sorties') {
            $transactions->where('type', 'expense');
        }

        // Recherche par mot-clé
        if (!empty($search)) {
            $transactions->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%$search%")
                    ->orWhere('amount', 'like', "%$search%")
                    ->orWhere('date', 'like', "%$search%");
            });
        }

        $result = $transactions->paginate(10);

        return $result;
    }

    public function store($data, $type)
    {
        if ($type == 1) {
            return Income::create($data);
        } else {
            return Expenses::create($data);
        }
    }

    public function getAbb()
    {
        $abb = Income::whereNotNull('abb_id')->with('user')->paginate(10);
        return $abb;
    }
    public function getSale()
    {
        $sale = Income::whereNotNull('sale_id')->with('user')->paginate(10);
        return $sale;
    }
    public function getRest()
    {
        $rest = Abonnement::where('rest', '>', 0)->with('client')->paginate(10);
        return $rest;
    }

    public function getDailyIncome()
    {
        return Income::whereDate('created_at', today())->sum('amount');
        // Income::whereDay('created_at', now()->day)
        //     ->whereMonth('created_at', now()->month)
        //     ->whereYear('created_at', now()->year)
        //     ->sum('amount');
    }
    public function getDailyExpense()
    {
        return Expenses::whereDate('created_at', today())->sum('amount');
    }
    
    public function getWeeklyIncome()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Début de la semaine (lundi)
        $endOfWeek = Carbon::now()->endOfWeek(); // Fin de la semaine (dimanche)

        $weeklyIncome = Income::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        return $weeklyIncome;
    }
    public function getWeeklyExpense()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Début de la semaine (lundi)
        $endOfWeek = Carbon::now()->endOfWeek(); // Fin de la semaine (dimanche)

        $weeklyExpense = Expenses::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        return $weeklyExpense;
    }

    public function getMonthlyIncome()
    {
        return Income::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
    }
    public function getMonthlyExpense()
    {
        return Expenses::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
    }

    public function getYearlyIncome()
    {
        return Income::whereYear('created_at', now()->year)->sum('amount');
    }
    public function getYearlyExpense()
    {
        return Expenses::whereYear('created_at', now()->year)->sum('amount');
    }
}
