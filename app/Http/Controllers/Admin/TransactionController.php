<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil data transaksi beserta User dan Order
        // Urutkan dari yang terbaru
        $transactions = Transaction::with(['user', 'order'])
            ->latest()
            ->paginate(15);

        // Hitung total uang masuk yang sukses saja
        $totalIncome = Transaction::where('status', 'success')->sum('amount');
        $pendingCount = Transaction::where('status', 'pending')->count();

        return view('admin.transactions.index', compact('transactions', 'totalIncome', 'pendingCount'));
    }

    // Fitur hapus history transaksi (opsional)
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return back()->with('success', 'Riwayat transaksi dihapus.');
    }
}