<?php

namespace App\Http\Controllers;

use App\Models\ZakatTransaction;
use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ZakatTransactionController extends Controller
{
    public string $title = "Transaksi Zakat";

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

        return view('zakat-transactions.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $muzakkis = Muzakki::all('id', 'name');
        return view('zakat-transactions.create', compact('muzakkis'), [
            'title' => $this->title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'muzakki_id' => 'required|exists:muzakkis,id',
            'types_of_zakat' => 'required|in:fitrah,mal,profesi,lainnya',
            'amount' => 'required|numeric|min:1',
            'zakat_transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            ZakatTransaction::create($request->all() + ['created_by' => Auth::id()]);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'redirect' => route('zakat-transactions.create')
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ZakatTransaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZakatTransaction $transaction)
    {
        $muzakkis = Muzakki::all('id', 'name');
        return view('zakat-transactions.edit', [
            'title' => $this->title,
            'data' => $transaction,
            'muzakkis' => $muzakkis
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ZakatTransaction $transaction)
    {
        // Validasi
        $request->validate([
            'muzakki_id' => 'required|exists:muzakkis,id',
            'types_of_zakat' => 'required|in:fitrah,mal,profesi,lainnya',
            'amount' => 'required|numeric|min:1',
            'zakat_transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $transaction = ZakatTransaction::findOrFail($transaction->id);
            if (!$transaction) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => "Data tidak ditemukan.",
                ], 404));
            }

            $transaction->update($request->all() + ['updated_by' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah.',
                'redirect' => route('zakat-transactions.edit', $transaction->id)
            ], 200);
        } catch (HttpResponseException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZakatTransaction $transaction)
    {
        try {
            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus karena masih terhubung dengan data lain.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ], 500);
        }
    }
}
