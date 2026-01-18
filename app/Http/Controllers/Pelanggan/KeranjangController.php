<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        return view('pelanggan.keranjang.index', compact('keranjangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $produk = Produk::find($request->produk_id);


        if ($produk->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $produk->stok);
        }

        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($keranjang) {

            $totalQty = $keranjang->qty + $request->quantity;


            if ($produk->stok < $totalQty) {
                return back()->with('error', 'Stok tidak mencukupi untuk menambah jumlah ini. Stok tersedia: ' . $produk->stok . ', sudah di keranjang: ' . $keranjang->qty);
            }


            $keranjang->update(['qty' => $totalQty]);
        } else {
            // Buat baru jika belum ada
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->produk_id,
                'qty' => $request->quantity
            ]);
        }

        return redirect()->route('keranjang')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $keranjang = Keranjang::where('user_id', Auth::id())
            ->with('produk')
            ->findOrFail($id);


        if ($keranjang->produk->stok < $request->quantity) {
            return response()->json([
                'message' => 'Stok tidak mencukupi. Stok maksimal: ' . $keranjang->produk->stok
            ], 400);
        }

        $keranjang->update(['qty' => $request->quantity]);

        return response()->json([
            'message' => 'Jumlah produk berhasil diperbarui.',
            'data' => [
                'qty' => $keranjang->qty,
                'subtotal' => $keranjang->produk->harga * $keranjang->qty
            ]
        ]);
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $keranjang->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus dari keranjang.'
        ]);
    }


    public function clear()
    {
        Keranjang::where('user_id', Auth::id())->delete();

        return response()->json([
            'message' => 'Semua produk berhasil dihapus dari keranjang.'
        ]);
    }

    public function getTotal()
    {
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        $total = 0;
        foreach ($keranjangs as $keranjang) {
            $total += $keranjang->produk->harga * $keranjang->qty;
        }

        return response()->json([
            'total' => $total,
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.')
        ]);
    }
}
