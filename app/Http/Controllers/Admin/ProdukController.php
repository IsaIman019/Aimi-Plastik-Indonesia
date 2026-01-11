<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // <--- 1. WAJIB TAMBAHKAN INI
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Produk::with(['kategori', 'varian']);

            if ($request->search) {
                $query->where('nama', 'like', "%{$request->search}%");
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('kategori_id')) {
                $query->where('kategori_id', $request->kategori_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kategori', fn ($row) =>
                    $row->kategori?->nama ?? '-'
                )
                ->addColumn('harga', fn ($row) =>
                    'Rp ' . number_format($row->harga, 0, ',', '.')
                )
                ->addColumn('stok', fn ($row) =>
                    $row->stok . ' Pcs'
                )
                ->addColumn('status', fn ($row) => $row->status)
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex justify-center gap-2">
                        <a href="'.route('admin.products.edit', $row->id).'"
                            class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 flex items-center justify-center">✏️</a>
                        <button onclick="deleteProduct('.$row->id.', \''.e($row->nama).'\')"
                            class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">🗑️</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $produk = Produk::with('kategori')->latest()->paginate(10);

        return view('admin.produk.render.index', compact('produk'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // <--- 2. TAMBAHKAN BARIS INI
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['image']);
        
        // Update Slug jika nama berubah
        $data['slug'] = Str::slug($request->name); // <--- 3. TAMBAHKAN BARIS INI JUGA

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}