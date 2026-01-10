<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {

        $query = Kategori::query();

        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <div class="flex justify-center gap-2">
                    <button onclick="editKategori('.$row->id.')"
                        class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">✏️</button>
                    <button onclick="deleteKategori('.$row->id.', \''.e($row->nama).'\')"
                        class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">🗑️</button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.categories.render.index');
}


    public function store(Request $request)
{
    $request->validate([
        'nama'      => 'required|string|max:100|unique:kategori,nama',
        'deskripsi' => 'nullable|string',
        'status'    => 'required|in:ACTIVE,INACTIVE',
    ]);

    Kategori::create([
        'nama'      => $request->nama,
        'deskripsi' => $request->deskripsi,
        'status'    => $request->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Kategori berhasil ditambahkan'
    ]);
}

    public function edit($id)
{
    $kategori = Kategori::findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $kategori
    ]);
}

public function update(Request $request, $id)
{
    $kategori = Kategori::findOrFail($id);

    $validated = $request->validate([
        'nama'      => 'required|string|max:100|unique:kategori,nama,' . $id,
        'deskripsi' => 'nullable|string',
        'status'    => 'required|in:ACTIVE,INACTIVE',
    ]);

    $kategori->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Kategori berhasil diperbarui'
    ]);
}

    public function destroy($id)
    {
        try {
            $kategori = Kategori::find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak ditemukan'
                ], 404);
            }

            DB::beginTransaction();

            if (method_exists($kategori, 'produk') && $kategori->produk()->exists()) {

                $count = $kategori->produk()->count();
                return response()->json([
                    'success' => false,
                    'message' => "Kategori tidak dapat dihapus karena masih memiliki {$count} produk"
                ], 400);
            }

            $nama = $kategori->nama;
            $kategori->delete();

            DB::commit();

            Log::info('Kategori deleted', ['id' => $id, 'nama' => $nama]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori "' . $nama . '" berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting kategori: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}
