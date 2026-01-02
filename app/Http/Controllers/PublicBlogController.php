<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    // Halaman Daftar Berita
    public function index()
    {
        // Ambil berita aktif, urutkan terbaru, paginasi 9 item per halaman
        $allNews = News::where('is_active', true)->latest()->paginate(9);
        return view('blog.index', compact('allNews'));
    }

    // Halaman Detail Berita
    public function show($id)
    {
        // Ambil 1 berita berdasarkan ID
        $news = News::where('is_active', true)->findOrFail($id);

        // Ambil berita lain sebagai rekomendasi (sidebar)
        $recentNews = News::where('is_active', true)
                          ->where('id', '!=', $id)
                          ->latest()
                          ->take(5)
                          ->get();

        return view('blog.show', compact('news', 'recentNews'));
    }
}