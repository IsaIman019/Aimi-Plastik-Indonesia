<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product;
use App\Models\Produk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Promo::query()->select('promo.*');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('periode', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y')
                        . ' - ' .
                        \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y');
                })

                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex justify-center gap-2">
                        <button onclick="editPromo('.$row->id.')"
                            class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                            ✏️
                        </button>
                        <button onclick="deletePromo('.$row->id.', \''.e($row->nama).'\')"
                            class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                            🗑️
                        </button>
                    </div>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        $produks = Produk::where('status', 'ACTIVE')->get();

        return view('admin.promos.render.index', compact('produks'));
    }




public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string',
        'kode' => 'required|unique:promo,kode',
        'tipe' => 'required|in:percent,fixed',
        'jumlah' => 'required|numeric|min:0',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'status' => 'required|in:ACTIVE,INACTIVE',
        'produk_ids' => 'required_if:is_all_product,0|array|min:1',
        'produk_ids.*' => 'exists:produk,id',
    ]);

    $promo = Promo::create([
        'nama' => $request->nama,
        'kode' => $request->kode,
        'tipe' => $request->tipe,
        'jumlah' => $request->jumlah,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'is_all_product' => $request->boolean('is_all_product'),
        'status' => $request->status,
    ]);

    if ($promo->is_all_product) {
        $produkIds = Produk::where('status', 'ACTIVE')->pluck('id')->toArray();
        $promo->produks()->sync($produkIds);
    } else {
        $promo->produks()->sync($request->produk_ids);
    }

    return response()->json(['success' => true]);
}


public function edit($id)
{
    $promo = Promo::with('produks')->findOrFail($id);

    return response()->json([
        'id' => $promo->id,
        'nama' => $promo->nama,
        'kode' => $promo->kode,
        'tipe' => $promo->tipe,
        'jumlah' => $promo->jumlah,
        'status' => $promo->status,
        'is_all_product' => $promo->is_all_product,
        'tanggal_mulai' => $promo->tanggal_mulai?->format('Y-m-d'),
        'tanggal_selesai' => $promo->tanggal_selesai?->format('Y-m-d'),
        'produk_ids' => $promo->produks->pluck('id')->values()->toArray(),
    ]);
}


public function update(Request $request, $id)
{
    $promo = Promo::findOrFail($id);

    $data = $request->validate([
        'nama' => 'required',
        'kode' => 'required',
        'tipe' => 'required',
        'jumlah' => 'required|numeric',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date',
        'status' => 'required',
        'is_all_product' => 'boolean',
        'produk_ids' => 'array',
    ]);

    $promo->update(collect($data)->except('produk_ids')->toArray());

    if ($request->boolean('is_all_product')) {
        $promo->produks()->sync(Produk::pluck('id'));
    } else {
        $promo->produks()->sync($request->produk_ids ?? []);
    }

    return response()->json(['message' => 'Updated']);
}


public function destroy($id)
{
    Promo::findOrFail($id)->delete();
    return response()->json(['message' => 'Deleted']);
}

}