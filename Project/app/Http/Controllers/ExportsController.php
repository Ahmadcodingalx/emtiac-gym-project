<?php

namespace App\Http\Controllers;

use App\Interfaces\ExportsInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportsController extends Controller
{
    private ExportsInterface $exportsInterface;
    public function __construct(ExportsInterface $exportsInterface)
    {
        $this->exportsInterface = $exportsInterface;
    }
    //
    public function exportBilanPdf(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('m'));
        $transactions = $this->exportsInterface->exportBilanPdf($month);

        $incomes = $transactions['incomes'];
        $expenses = $transactions['expenses'];

        $pdf = Pdf::loadView('exports.bilans', [
            'month' => Carbon::createFromFormat('m', $month)->locale('fr')->translatedFormat('F'),
            'transactions' => $transactions['transactions'],
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);

        return $pdf->download('bilan_mensuel.pdf');
    }
    //
    public function exportRestPayPdf(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('m'));
        $rest = $this->exportsInterface->exportRestPayPdf($month);

        $pdf = Pdf::loadView('exports.all_pay', [
            'month' => Carbon::createFromFormat('m', $month)->locale('fr')->translatedFormat('F'),
            'rest' => $rest,
        ]);

        return $pdf->download('restes_mensuel.pdf');
    }
}
