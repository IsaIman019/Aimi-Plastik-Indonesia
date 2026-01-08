<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Kategori::select([
                    'id',
                    'nama',
                    'deskripsi',
                    'status',
                    'created_at'
                ]);

                // Apply search filter
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = htmlspecialchars($request->search['value'], ENT_QUOTES, 'UTF-8');
                    $query->where(function ($q) use ($search) {
                        $q->where('nama', 'LIKE', "%{$search}%")
                            ->orWhere('deskripsi', 'LIKE', "%{$search}%");
                    });
                }

                // Apply status filter
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('status', $request->status);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $editUrl = route('admin.categories.edit', $row->id);
                        $deleteUrl = route('admin.categories.destroy', $row->id);

                        // Secure output with htmlspecialchars for nama
                        $safeNama = htmlspecialchars($row->nama, ENT_QUOTES, 'UTF-8');

                        $btn = '<div class="flex items-center justify-end gap-2">';
                        $btn .= '<button onclick="editCategory(' . $row->id . ')" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-orange-600 hover:border-orange-200 transition shadow-sm" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>';
                        $btn .= '<button onclick="deleteCategory(' . $row->id . ', \'' . addslashes($safeNama) . '\')" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-red-600 hover:border-red-200 transition shadow-sm" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>';
                        $btn .= '</div>';

                        return $btn;
                    })
                    ->editColumn('nama', function ($row) {
                        // XSS Protection for output
                        $safeNama = htmlspecialchars($row->nama, ENT_QUOTES, 'UTF-8');
                        $safeDeskripsi = $row->deskripsi ? htmlspecialchars($row->deskripsi, ENT_QUOTES, 'UTF-8') : '';

                        return $safeNama;
                    })
                    ->editColumn('deskripsi', function ($row) {
                        return $row->deskripsi ? htmlspecialchars($row->deskripsi, ENT_QUOTES, 'UTF-8') : '';
                    })
                    ->editColumn('status', function ($row) {
                        $badgeClass = $row->status == 'ACTIVE' ? 'success' : 'danger';
                        $badgeText = htmlspecialchars($row->status, ENT_QUOTES, 'UTF-8');
                        return $badgeText;
                    })
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at->format('Y-m-d H:i:s');
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Terjadi kesalahan saat memuat data'
                ], 500);
            }
        }

        return view('admin.categories.index');
    }

    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:kategori,nama',
            'deskripsi' => 'nullable|string|max:500',
            'status' => 'required|in:ACTIVE,INACTIVE',

        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.max' => 'Nama kategori maksimal 100 karakter',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Sanitize input
            $nama = htmlspecialchars(strip_tags($request->nama), ENT_QUOTES, 'UTF-8');
            $deskripsi = $request->deskripsi ?
                htmlspecialchars(strip_tags($request->deskripsi), ENT_QUOTES, 'UTF-8') :
                null;

            $kategori = Kategori::create([
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'status' => $request->status,
                'color' => $request->color ?? '#f59e0b'
            ]);

            DB::commit();

            Log::info('Kategori created', ['id' => $kategori->id, 'nama' => $nama]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating kategori: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan kategori'
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            return response()->json([
                'id' => $kategori->id,
                'nama' => htmlspecialchars_decode($kategori->nama, ENT_QUOTES),
                'deskripsi' => $kategori->deskripsi ? htmlspecialchars_decode($kategori->deskripsi, ENT_QUOTES) : '',
                'status' => $kategori->status
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching kategori for edit: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100|unique:kategori,nama,' . $id,
                'deskripsi' => 'nullable|string|max:500',
                'status' => 'required|in:ACTIVE,INACTIVE',

            ], [
                'nama.required' => 'Nama kategori wajib diisi',
                'nama.max' => 'Nama kategori maksimal 100 karakter',
                'status.required' => 'Status wajib dipilih',
                'status.in' => 'Status tidak valid',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Sanitize input
            $nama = htmlspecialchars(strip_tags($request->nama), ENT_QUOTES, 'UTF-8');
            $deskripsi = $request->deskripsi ?
                htmlspecialchars(strip_tags($request->deskripsi), ENT_QUOTES, 'UTF-8') :
                null;

            $kategori->update([
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'status' => $request->status,
            ]);

            DB::commit();

            Log::info('Kategori updated', ['id' => $kategori->id, 'nama' => $nama]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui',
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating kategori: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kategori'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            DB::beginTransaction();

            // Check if category has products
            if ($kategori->products()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih memiliki produk'
                ], 400);
            }

            $kategori->delete();

            DB::commit();

            Log::info('Kategori deleted', ['id' => $id, 'nama' => $kategori->nama]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting kategori: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori'
            ], 500);
        }
    }
}
