<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\produk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StokController extends Controller
{
    // 1. TAMPILKAN HALAMAN MANAJEMEN STOK
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Produk::with('kategori')
                ->select('produk.id', 'produk.nama', 'produk.stok', 'produk.status', 'produk.kategori_id');

            if ($request->search) {
                $query->where('nama', 'like', "%{$request->search}%");
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->kategori_id) {
                $query->where('kategori_id', $request->kategori_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kategori', fn ($row) => $row->kategori?->nama ?? '-')
                ->make(true);
        }

        $kategoris = Kategori::orderBy('nama')->get();

        return view('admin.stok.render.index', compact('kategoris'));
    }

    // 2. PROSES UPDATE STOK CEPAT
   public function update(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $produk = Produk::findOrFail($id);

        $produk->update([
            'stok' => $request->stok,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }
}