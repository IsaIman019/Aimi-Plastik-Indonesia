<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * ============================
     * LIST SEMUA ULASAN
     * ============================
     */
    public function index()
    {
        return view('admin.reviews.index', [
            'reviews' => Review::with(['user','product'])
                ->latest()
                ->paginate(20)
        ]);
    }

    /**
     * ============================
     * DETAIL ULASAN
     * ============================
     */
    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * ============================
     * AKTIFKAN / NONAKTIFKAN
     * ============================
     */
    public function toggleStatus(Review $review)
    {
        $review->update([
            'is_active' => !$review->is_active
        ]);

        return back()->with(
            'success',
            $review->is_active
                ? 'Ulasan disetujui'
                : 'Ulasan dinonaktifkan'
        );
    }

    /**
     * ============================
     * HAPUS ULASAN
     * ============================
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan dihapus permanen');
    }
}
