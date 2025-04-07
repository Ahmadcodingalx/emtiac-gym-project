<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{

    protected $columns;

    // 🔹 Accepter les colonnes à afficher
    public function __construct($columns = [])
    {
        $this->columns = $columns;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Transaction::all();

        //********************* */

        // // Récupération des transactions en union
        // $incomeQuery = DB::table('incomes')
        //     ->select(
        //         'incomes.id', 'incomes.user_id', 'incomes.date',
        //         'incomes.amount', 'incomes.reason',
        //         DB::raw("'income' as type"), 'users.firstname', 'users.lastname'
        //     )
        //     ->join('users', 'users.id', '=', 'incomes.user_id');

        // $expensesQuery = DB::table('expenses')
        //     ->select(
        //         'expenses.id', 'expenses.user_id', 'expenses.date',
        //         'expenses.amount', 'expenses.reason',
        //         DB::raw("'expense' as type"), 'users.firstname', 'users.lastname'
        //     )
        //     ->join('users', 'users.id', '=', 'expenses.user_id');

        // // Union des requêtes
        // return DB::table(DB::raw("({$incomeQuery->toSql()} UNION {$expensesQuery->toSql()}) as transactions"))
        //     ->mergeBindings($incomeQuery)
        //     ->mergeBindings($expensesQuery)
        //     ->orderBy('date', 'desc')
        //     ->get();

        //*************************** */



        $allColumns = [
            'id' => 'transactions.id',
            'user_id' => 'transactions.user_id',
            'date' => 'transactions.date',
            'amount' => 'transactions.amount',
            'reason' => 'transactions.reason',
            'type' => 'transactions.type',
            'firstname' => 'transactions.firstname',
            'lastname' => 'transactions.lastname'
        ];

        // 🔹 Sélectionner uniquement les colonnes demandées
        $selectedColumns = [];
        foreach ($this->columns as $column) {
            if (isset($allColumns[$column])) {
                $selectedColumns[] = $allColumns[$column];
            }
        }

        if (empty($selectedColumns)) {
            $selectedColumns = array_values($allColumns); // Si aucune colonne sélectionnée, prendre tout
        }

        // 🔹 Requête pour récupérer les données
        $incomeQuery = DB::table('incomes')
            ->selectRaw("
                users.lastname AS lastname,
                users.firstname AS firstname,
                incomes.amount AS amount,
                incomes.reason AS reason,
                'income' AS type,
                incomes.date AS date
            ")
            ->join('users', 'users.id', '=', 'incomes.user_id');

        $expensesQuery = DB::table('expenses')
            ->selectRaw("
                users.lastname AS lastname,
                users.firstname AS firstname,
                expenses.amount AS amount,
                expenses.reason AS reason,
                'expense' AS type,
                expenses.date AS date
            ")
            ->join('users', 'users.id', '=', 'expenses.user_id');


        $transactions = DB::table(DB::raw("({$incomeQuery->toSql()} UNION ALL {$expensesQuery->toSql()}) as transactions"))
            ->mergeBindings($incomeQuery)
            ->mergeBindings($expensesQuery)
            ->orderBy('transactions.date', 'desc')
            ->get();

        return $transactions;
    }

    // 🔹 Ajouter les noms des colonnes
    // public function headings(): array
    // {
    //     return [
    //         'ID', 'User ID', 'Date', 'Montant', 'Motif', 'Type', 'Prénom', 'Nom'
    //     ];
    // }


    public function headings(): array
    {
        // Correspondance entre les noms des colonnes dans la base de données et les titres à afficher
        $headingsMap = [
            'firstname' => 'Nom',
            'lastname' => 'Prénom',
            'amount' => 'Montant',
            'reason' => 'Motif',
            'type' => 'Type',
            'date' => 'Date'
        ];

        // // 🔹 Générer les en-têtes basés sur les colonnes sélectionnées
        // return array_map(fn($col) => $headingsMap[$col] ?? $col, $this->columns);

        // 🔹 Générer les en-têtes basés sur les colonnes sélectionnées
        $headings = [];
        foreach ($this->columns as $column) {
            if (isset($headingsMap[$column])) {
                $headings[] = $headingsMap[$column];
            }
        }

        // 🔹 Si aucune colonne n'est sélectionnée, afficher tous les en-têtes
        if (empty($headings)) {
            $headings = array_values($headingsMap);
        }

        return $headings;
    }
}
