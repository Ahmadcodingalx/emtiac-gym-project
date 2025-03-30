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

    public function transList(Request $request)
    {

        $transactions = $this->transactionInterface->transList($request);

        return view('stats_bilan/incomes_expences', compact('transactions'));
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
