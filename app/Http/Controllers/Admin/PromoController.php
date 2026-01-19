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

        // ⬇️ hanya wajib kalau TIDAK all product
        'produk_ids' => 'required_if:is_all_product,0|array',
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

    // 🔥 INSERT pivot
    if (!$promo->is_all_product) {
        $promo->produks()->sync($request->produk_ids);
    }

    return response()->json(['success' => true]);
}


    public function edit(Promo $promo)
    {
        $products = Product::all();
        // Ambil ID produk yang sedang terhubung dengan promo ini
        $selectedProducts = $promo->products->pluck('id')->toArray();
        
        return view('admin.promos.edit', compact('promo', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'products' => 'required|array'
        ]);

        $promo->update($request->except('products'));
        $promo->products()->sync($request->products); // Update relasi produk

        return redirect()->route('admin.promos.index')->with('success', 'Promo diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Promo dihapus.');
    }
}