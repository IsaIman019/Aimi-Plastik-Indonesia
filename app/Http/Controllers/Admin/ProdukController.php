<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\General;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Produk::with(['kategori', 'varian']);

            if ($request->search) {
                $query->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('varian_id', 'like', "%{$request->search}%");
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('kategori_id')) {
                $query->where('kategori_id', $request->kategori_id);
            }

            if ($request->filled('varian_id')) {
                $query->where('varian_id', $request->varian_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kategori', fn($row) => $row->kategori?->nama ?? '-')
                ->addColumn('varian', fn($row) => $row->varian?->value ?? '-')
                ->addColumn('harga', fn($row) => 'Rp ' . number_format($row->harga, 0, ',', '.'))
                ->addColumn('stok', fn($row) => $row->stok . ' Pcs')
                ->addColumn('status', function ($row) {
                    $badge = $row->status == 'ACTIVE'
                        ? 'bg-green-100 text-green-800'
                        : 'bg-red-100 text-red-800';
                    return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $badge . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex justify-center gap-2">
                        <button onclick="editProduk(' . $row->id . ')" class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">✏️</button>
                        <button onclick="deleteProduk(' . $row->id . ', \'' . e($row->nama) . '\')" class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">🗑️</button>
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $kategoris = Kategori::where('status', 'ACTIVE')->get();
        $varians = General::query()
            ->where('key', 'Varian Produk')
            ->where('status', 'ACTIVE')
            ->get(['id', 'value as nama']);

        return view('admin.produk.render.index', compact('kategoris', 'varians'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'nullable|exists:kategori,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'varian_id' => 'required',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'nullable|string',
            'panjang' => 'nullable|string',
            'lebar' => 'nullable|string',
            'tinggi' => 'nullable|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'is_featured' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produk', 'public');
        }

        Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'image' => $imagePath,
            'varian_id' => $request->varian_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'berat' => $request->berat,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'status' => $request->status,
            'is_featured' => $request->is_featured ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'kategori_id' => 'nullable|exists:kategori,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'varian_id' => 'required',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'nullable|string',
            'panjang' => 'nullable|string',
            'lebar' => 'nullable|string',
            'tinggi' => 'nullable|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($produk->image && Storage::exists('public/' . $produk->image)) {
                Storage::delete('public/' . $produk->image);
            }
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        $produk->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui',
            'data' => $produk
        ]);
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::find($id);

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            DB::beginTransaction();
            if ($produk->image) {
                Storage::disk('public')->delete($produk->image);
            }

            $nama = $produk->nama;
            $produk->delete();

            DB::commit();

            Log::info('Produk deleted', [
                'id' => $id,
                'nama' => $nama
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Produk "' . $nama . '" berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting produk', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data produk'
            ], 500);
        }
    }
}
