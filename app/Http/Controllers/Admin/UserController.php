<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
// PERBAIKAN IMPORT (Penting agar tidak error):
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = User::query()
                ->select('users.*');

            $search = $request->search;

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
                });
            }
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                
                
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex justify-center gap-2">
                        <button onclick="editUser('.$row->id.')"
                            class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                            ✏️
                        </button>
                        <button onclick="deleteUser('.$row->id.', \''.e($row->nama).'\')"
                            class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                            🗑️
                        </button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.render.index');
    }


    public function store(Request $request)
    {
        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:6',
            'role'     => 'required|in:Admin,Pelanggan',
            'status'   => 'required|in:ACTIVE,INACTIVE',
        ]);

        $user->nama   = $validated['nama'];
        $user->phone  = $validated['phone'] ?? null;
        $user->role   = $validated['role'];
        $user->status = $validated['status'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            DB::beginTransaction();

            $nama = $user->nama;
            $user->delete();

            DB::commit();

            Log::info('User deleted', ['id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'User "' . $nama . '" berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus user'
            ], 500);
        }
    }
}