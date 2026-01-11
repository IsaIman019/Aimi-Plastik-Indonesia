<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Artikel::query();

            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', "%{$request->search}%")
                        ->orWhere('konten', 'like', "%{$request->search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex justify-center gap-2">
                        <button onclick="editNews(' . $row->id . ')" class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">✏️</button>
                        <button onclick="deleteNews(' . $row->id . ', \'' . e($row->judul) . '\')" class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">🗑️</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kategori = Kategori::all();
        return view('admin.news.render.index', compact('kategori'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori_id' => 'required',
            'konten' => 'required|max:255',
            'status' => 'required|in:DRAFT,ACTIVE,INACTIVE',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Validasi ukuran file
            $file = $request->file('gambar');
            if ($file->getSize() > 2097152) { // 2MB dalam bytes
                return response()->json([
                    'success' => false,
                    'message' => 'Ukuran gambar maksimal 2MB',
                    'errors' => ['gambar' => ['Ukuran gambar maksimal 2MB']]
                ], 422);
            }

            // Generate nama file unik
            $gambarName = 'artikel_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage/app/public/artikel
            $gambarPath = $file->storeAs('artikel', $gambarName, 'public');
        }

        Artikel::create([
            'judul' => $request->judul,
            'gambar' => $gambarPath,
            'kategori_id' => $request->kategori_id,
            'konten' => $request->konten,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'News berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $news = Artikel::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    public function update(Request $request, $id)
    {
        $news = Artikel::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori_id' => 'required',
            'konten' => 'required|max:255',
            'status' => 'required|in:DRAFT,ACTIVE,INACTIVE',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($news->gambar) {
                Storage::disk('public')->delete($news->gambar);
            }
            $news->gambar = $request->file('gambar')->store('news', 'public');
        }

        $news->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'News berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        try {
            $news = Artikel::find($id);

            if (!$news) {
                return response()->json([
                    'success' => false,
                    'message' => 'News tidak ditemukan'
                ], 404);
            }

            DB::beginTransaction();
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $judul = $news->judul;
            $news->delete();

            DB::commit();

            Log::info('News deleted', [
                'id' => $id,
                'judul' => $judul
            ]);

            return response()->json([
                'success' => true,
                'message' => 'News "' . $judul . '" berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting news', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data news'
            ], 500);
        }
    }
}
