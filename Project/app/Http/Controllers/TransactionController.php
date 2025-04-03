<?php

namespace App\Http\Controllers;

use App\Interfaces\TransactionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private TransactionInterface $transactionInterface;

    public function __construct(TransactionInterface $transactionInterface)
    {
        $this->transactionInterface = $transactionInterface;
    }

    
    public function addTrans()
    {
        return view('stats_bilan/addTrans');
    }
    
    public function bilans()
    {
        $day_income = $this->transactionInterface->getDailyIncome();
        $week_income = $this->transactionInterface->getWeeklyIncome();
        $month_income = $this->transactionInterface->getMonthlyIncome();
        $year_income = $this->transactionInterface->getYearlyIncome();
        //**************** */
        $day_expense = $this->transactionInterface->getDailyExpense();
        $week_expense = $this->transactionInterface->getWeeklyExpense();
        $month_expense = $this->transactionInterface->getMonthlyExpense();
        $year_expense = $this->transactionInterface->getYearlyExpense();
        //**************** */
        // $day = $day_expense - $day_income;
        // $week = $week_expense - $week_income;
        // $month = $month_expense - $month_income;
        // $year = (-$year_expense) + 100000;
        // dd([
        //     'year_expense' => $year_expense,
        //     'year_income' => $year_income,
        //     'diff' => $year
        // ]);

        return view('stats_bilan/recettes', compact(
            'day_income',
            'week_income',
            'month_income',
            'year_income',
            //****** */
            'day_expense',
            'week_expense',
            'month_expense',
            'year_expense',
            //****** */
            // 'day',
            // 'week',
            // 'month',
            // 'year'
        ));
    }

    public function transList(Request $request)
    {

        $transactions = $this->transactionInterface->transList($request);
        $abb = $this->transactionInterface->getAbb();
        $sales = $this->transactionInterface->getSale();
        $rests = $this->transactionInterface->getRest();

        return view('stats_bilan/incomes_expences', compact('transactions', 'abb', 'sales', 'rests'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'amount' => 'required',
            'nature' => 'required',
            'transaction' => 'required|in:income,expense',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'type' => $request->nature,
            'date' => $request->date,
            'amount' => $request->amount,
            'reason' => $request->desc,
        ];

        $type = $request->transaction === 'income' ? 1 : 2;

        DB::beginTransaction();
        try {
            $trans = $this->transactionInterface->store($data, $type);

            if ($trans) {
                DB::commit();
                return back()->with('success', 'Oppération éffectuée avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Oppération a échoué.']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création de la transaction.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function bilanComplet($periode)
    // {
    //     $revenus = $this->getRevenus($periode);
    //     $depenses = Depense::whereBetween('date', [now()->startOfPeriod($periode), now()->endOfPeriod($periode)])->sum('montant');

    //     return view('bilan', compact('revenus', 'depenses'));
    // }
}
