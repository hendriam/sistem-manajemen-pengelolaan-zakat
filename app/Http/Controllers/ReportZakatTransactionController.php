<?php

namespace App\Http\Controllers;

use App\Models\ZakatTransaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportZakatTransactionController extends Controller
{
    public string $title = "Laporan Transaksi Zakat";

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                'id',
                'zakat_transaction_date',
                'muzakki.name',
                'types_of_zakat',
                'amount',
                'created_by',
                'created_at'
            ];
            $totalData = ZakatTransaction::count();

            $limit = $request->input('length');   // jumlah data per halaman
            $start = $request->input('start');    // offset

            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $query = ZakatTransaction::with(['muzakki', 'createdBy', 'updatedby']);

            // jika tidak ada filter tanggal, buat default pertanggal hari ini
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
            }

            $query->whereBetween('zakat_transaction_date', [
                $start_date,
                $end_date
            ]);

            // Search filter
            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            $totalFiltered = $query->count();

            $data = $query
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalFiltered,
                "data" => $data
            ]);
        }

        return view('report-zakat-transactions.index', ['title' => $this->title]);
    }

    public function exportPDF(Request $request)
    {
        $transactions = $this->filteredTransactions($request)->get();
        // dd($transactions);
        $pdf = Pdf::loadView('report-zakat-transactions.pdf', compact('transactions'));
        return $pdf->download('laporan_zakat.pdf');
    }

    private function filteredTransactions(Request $request)
    {
        $query = ZakatTransaction::with(['muzakki', 'createdBy', 'updatedby']);

        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');

        if ($request->start_date && $request->end_date) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
        }

        $query->whereBetween('zakat_transaction_date', [$start_date, $end_date]);

        return $query;
    }
}
