<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class PublicArtikelController extends Controller
{
    // Halaman Daftar Berita
    public function index()
    {

        $allArtikel = Artikel::All();
        return view('artikel.index', compact('allArtikel'));
        // return view('artikel.index');
    }

    // Halaman Detail Berita
    public function show($id)
    {
        // Ambil 1 berita berdasarkan ID
        // $Artikel = Artikel::where('is_active', true)->findOrFail($id);

        // // Ambil berita lain sebagai rekomendasi (sidebar)
        // $recentArtikel = Artikel::where('is_active', true)
        //     ->where('id', '!=', $id)
        //     ->latest()
        //     ->take(5)
        //     ->get();

        return view('artikel.show', compact('artikel', 'recentArtikel'));
    }
}
