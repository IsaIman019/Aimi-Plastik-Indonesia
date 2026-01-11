<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PublicArtikelController extends Controller
{
    // Halaman Daftar Berita
    public function index()
    {
        // Ambil semua artikel aktif untuk ditampilkan
        $allArtikel = Artikel::where('status', 'ACTIVE')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil artikel terbaru untuk featured article
        $featuredArticle = Artikel::where('status', 'ACTIVE')
            ->latest()
            ->first();

        // Ambil artikel populer (misalnya berdasarkan view count atau yang paling baru)
        $popularArticles = Artikel::where('status', 'ACTIVE')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Ambil artikel berdasarkan kategori
        $articlesByCategory = $this->getArticlesByCategory();

        return view('artikel.index', compact(
            'allArtikel',
            'featuredArticle',
            'popularArticles',
            'articlesByCategory'
        ));
    }

    /**
     * Ambil artikel berdasarkan kategori (4 artikel per kategori)
     */
    private function getArticlesByCategory()
    {
        // Jika ada tabel kategori, ambil semua kategori
        $categories = Kategori::all();

        $result = [];

        foreach ($categories as $category) {
            $articles = Artikel::where('status', 'ACTIVE')
                ->where('kategori_id', $category->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();

            if ($articles->count() > 0) {
                $result[] = [
                    'kategori' => $category,
                    'articles' => $articles
                ];
            }
        }

        return $result;
    }

    /**
     * Halaman Detail Artikel
     */
    public function show($id)
    {
        $artikel = Artikel::where('status', 'ACTIVE')->findOrFail($id);

        // Get related articles (same category)
        $recentArtikel = Artikel::where('status', 'ACTIVE')
            ->where('kategori_id', $artikel->kategori_id)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get popular articles (you can add view count logic)
        $popularArticles = Artikel::where('status', 'ACTIVE')
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('artikel.show', compact('artikel', 'recentArtikel', 'popularArticles'));
    }

    /**
     * Artikel berdasarkan kategori
     */
    public function byCategory($categoryId)
    {
        $kategori = Kategori::findOrFail($categoryId);

        $articles = Artikel::where('status', 'ACTIVE')
            ->where('kategori_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('artikel.category', compact('articles', 'kategori'));
    }
}
