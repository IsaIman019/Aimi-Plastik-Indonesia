<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\{Review, OrderItem, Product};
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * ============================
     * SIMPAN ULASAN PRODUK
     * ============================
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        // Cek apakah user sudah membeli produk
        $hasPurchased = OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())
                  ->where('status', 'paid');
            })->exists();

        if (!$hasPurchased) {
            abort(403, 'Anda hanya dapat memberi ulasan setelah membeli produk ini.');
        }

        // Cegah double review
        if (Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan.');
        }

        Review::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_active'  => false // menunggu moderasi admin
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim dan menunggu persetujuan.');
    }

    /**
     * ============================
     * HAPUS ULASAN SENDIRI
     * ============================
     */
    public function destroy(Review $review)
    {
        abort_if($review->user_id !== auth()->id(), 403);

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
