<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\ZakatTransaction;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Dashboard";

        $total_muzakki   = Muzakki::count();
        $total_mustahik  = Mustahik::count();
        $total_zakat     = ZakatTransaction::sum('amount');
        $total_distribusi = Distribution::sum('amount');
        $saldo_zakat     = $total_zakat - $total_distribusi;

        $pemasukan_per_bulan = ZakatTransaction::select(
            DB::raw("MONTH(zakat_transaction_date) as bulan"),
            DB::raw("SUM(amount) as total")
        )
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $distribusi_per_bulan = Distribution::select(
            DB::raw("MONTH(distribution_date) as bulan"),
            DB::raw("SUM(amount) as total")
        )
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $pemasukan_arr = array_fill(1, 12, 0);
        foreach ($pemasukan_per_bulan as $bulan => $total) {
            $pemasukan_arr[(int)$bulan] = (int)$total;
        }

        $distribusi_arr = array_fill(1, 12, 0);
        foreach ($distribusi_per_bulan as $bulan => $total) {
            $distribusi_arr[(int)$bulan] = (int)$total;
        }

        return view('dashboard', compact(
            'title',
            'total_muzakki',
            'total_mustahik',
            'total_zakat',
            'total_distribusi',
            'saldo_zakat',
            'pemasukan_arr',
            'distribusi_arr',
        ));
    }
}
