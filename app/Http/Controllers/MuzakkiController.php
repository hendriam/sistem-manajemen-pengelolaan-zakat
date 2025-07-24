<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class MuzakkiController extends Controller
{
    public string $title = "Muzakki";

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                'id',
                'name',
                'address',
                'phone',
                'created_by',
                'created_at' 
            ];
            $totalData = Muzakki::count();

            $limit = $request->input('length');   // jumlah data per halaman
            $start = $request->input('start');    // offset

            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $query = Muzakki::with(['createdBy', 'updatedby']);

            // Search filter
            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function($q) use ($search) {
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

        return view('muzakkis.index', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('muzakkis.create', ['title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|min:3|max:14',
            'address' => 'required|min:3',
        ]);

        try {
            Muzakki::create($request->all() + ['created_by' => Auth::id()]);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'redirect' => route('muzakkis.create')
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Muzakki $muzakki)
    {
        return view('muzakkis.edit',[
            'title' => $this->title,
            'data' => $muzakki
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Muzakki $muzakki)
    {
        // Validasi
        $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|min:3|max:14',
            'address' => 'required|min:3',
        ]);

        try {
            $muzakki = Muzakki::findOrFail($muzakki->id);
            if (!$muzakki) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => "Data tidak ditemukan.",
                ], 404));
            }

            $muzakki->update($request->all() + ['updated_by' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah.',
                'redirect' => route('muzakkis.edit', $muzakki->id)
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
    public function destroy(Muzakki $muzakki)
    {
        try {
            if (!$muzakki) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }
                        
            $muzakki->delete();

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
