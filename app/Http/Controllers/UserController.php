<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected static ?string $password;
    protected string $title = "User";

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                'id',
                'name',
                'username', 
                'role', 
                'created_at' 
            ];
            $totalData = User::count();

            $limit = $request->input('length');   // jumlah data per halaman
            $start = $request->input('start');    // offset

            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $query = User::query();

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

        return view('users.index', ['title' => $this->title]);
    }

    public function create()
    {
        return view('users.create', ['title' => $this->title]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'username' => 'required|string|min:8|unique:users,username',
            'role' => 'required|in:admin,kasir,supervisor',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => static::$password ??= Hash::make('password'),
                'role' => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'redirect' => route('users.create')
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'title' => $this->title,
            'data' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'username' => 'required|string|min:8|unique:users,username,'.$user->id,
            'role' => 'required|in:admin,kasir,supervisor',
        ]);

        try {
            if (!$user) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => "Data tidak ditemukan.",
                ], 404));
            }

            $user->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah.',
                'redirect' => route('users.edit', $user->id)
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

    public function destroy(User $user)
    {
        try {
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }
                        
            $user->delete();

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
