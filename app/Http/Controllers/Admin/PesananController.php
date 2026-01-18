<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan masuk.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Pesanan::with(['user'])->select('pesanan.*');

            if ($request->filled('search')) {
                $searchValue = $request->search;
                $query->where(function ($q) use ($searchValue) {
                    $q->where('pesanan.no_pesanan', 'like', "%$searchValue%")
                        ->orWhere('pesanan.no_resi', 'like', "%$searchValue%")
                        ->orWhereHas('user', function ($u) use ($searchValue) {
                            $u->where('nama', 'like', "%$searchValue%");
                        });
                });
            }

            if ($request->filled('status')) {
                $query->where('pesanan.status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->nama : '-';
                })

                ->editColumn('status', function ($row) {
                    return $row->status;
                })
                ->editColumn('no_resi', function ($row) {
                    return $row->no_resi ?? '-';
                })
                ->editColumn('total_harga', function ($row) {
                    return 'Rp ' . number_format((float)$row->total_harga, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    return '
                <div class="flex justify-center gap-2">
                    <button onclick="editPesanan(' . $row->id . ')"
                        class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">✏️</button>
                </div>
            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pesanan.render.index');
    }
    /**
     * Update status pembayaran atau pengiriman.
     */
    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:pending,paid,processed,shipped,completed,cancelled',
    //         'payment_status' => 'required|in:unpaid,paid'
    //     ]);

    //     $order = Order::findOrFail($id);

    //     $order->update([
    //         'status' => $request->status,
    //         'payment_status' => $request->payment_status
    //     ]);

    //     return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    // }
}
