<?php

namespace App\Http\Controllers;

use App\Interfaces\DashboardInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private DashboardInterface $dashboardInterface;

    public function __construct(DashboardInterface $dashboardInterface)
    {
        $this->dashboardInterface = $dashboardInterface;
    }

    public function index()
    {
        $users = $this->dashboardInterface->get_user_data();
        $clients = $this->dashboardInterface->get_client_data();
        $incomes = $this->dashboardInterface->get_income_data();
        $expenses = $this->dashboardInterface->get_expense_data();
        $sale_income = $this->dashboardInterface->get_sale_income_data();

        return view('dashboard/index', compact(
            'users',
            'clients',
            'incomes',
            'expenses',
            'sale_income'
        ));
    }

    public function getSalesData(Request $request)
    {
        $period = $request->get('period', 'year'); // par défaut : année
        $query = DB::table('sales');

        switch ($period) {
            case 'day': // Aujourd’hui, par heure
                $data = $query->selectRaw('HOUR(created_at) as label, SUM(total) as total')
                    ->whereDate('created_at', Carbon::today())
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();

                // On génère toutes les heures de 0 à 23
                $fullLabels = collect(range(0, 23));
                break;

            case 'week': // Cette semaine, par jour
                $data = $query->selectRaw('DATE_FORMAT(created_at, "%a %d") as label, SUM(total) as total')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->groupBy('label')
                    ->orderByRaw('DATE(created_at)')
                    ->get();

                $fullLabels = collect();
                $start = Carbon::now()->startOfWeek();
                for ($i = 0; $i < 7; $i++) {
                    $fullLabels->push($start->copy()->addDays($i)->format('D d'));
                }
                break;

            case 'month': // Ce mois-ci, par jour
                $data = $query->selectRaw('DATE_FORMAT(created_at, "%d %b") as label, SUM(total) as total')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('label')
                    ->orderByRaw('DATE(created_at)')
                    ->get();

                $fullLabels = collect();
                $daysInMonth = Carbon::now()->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $fullLabels->push(str_pad($i, 2, '0', STR_PAD_LEFT) . ' ' . Carbon::now()->format('M'));
                }
                break;

            default: // Par défaut : par mois de l’année en cours
                $data = $query->selectRaw('DATE_FORMAT(created_at, "%b") as label, SUM(total) as total')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBy('label')
                    ->orderByRaw('MONTH(created_at)')
                    ->get();

                $fullLabels = collect([
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ]);
                break;
        }

        // Associer les valeurs aux labels, remplir les trous avec 0
        $formatted = $fullLabels->map(function ($label) use ($data) {
            $match = $data->firstWhere('label', $label);
            return [
                'label' => $label,
                'total' => $match ? (float) $match->total : 0,
            ];
        });

        return response()->json([
            'labels' => $formatted->pluck('label'),
            'values' => $formatted->pluck('total'),
        ]);
    }

    public function index2()
    {
        return view('dashboard/index2');
    }

    public function index3()
    {
        return view('dashboard/index3');
    }

    public function index4()
    {
        return view('dashboard/index4');
    }

    public function index5()
    {
        return view('dashboard/index5');
    }

    public function index6()
    {
        return view('dashboard/index6');
    }

    public function index7()
    {
        return view('dashboard/index7');
    }

    public function index8()
    {
        return view('dashboard/index8');
    }

    public function index9()
    {
        return view('dashboard/index9');
    }

    public function index10()
    {
        return view('dashboard/index10');
    }
}
