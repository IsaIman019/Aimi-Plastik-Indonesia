<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pelanggan.products')->with('error', 'Keranjang kosong.');
        }

        return view('pelanggan.checkout.index', compact('carts'));
    }

    public function process(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string', // Pastikan ini ada
        ]);

        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // 2. HITUNG TOTAL HARGA (PERBAIKAN UTAMA DI SINI)
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        // 3. Simpan ke Database dengan Transaction
        try {
            $order = DB::transaction(function () use ($request, $user, $carts, $totalPrice) {
                
                // A. Buat Order Utama
                $newOrder = Order::create([
                    'user_id' => $user->id,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(10)), // Generate Invoice Unik
                    'total_price' => $totalPrice, // <--- INI YANG TADI ERROR (Sekarang sudah ada)
                    'status' => 'pending',
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'shipping_method' => $request->shipping_method,
                    'payment_method' => $request->payment_method,
                ]);

                // B. Pindahkan Item dari Keranjang ke OrderItems
                foreach ($carts as $cart) {
                    OrderItem::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->product->price,
                    ]);

                    // C. Kurangi Stok Produk
                    $cart->product->decrement('stock', $cart->quantity);
                }

                // D. Kosongkan Keranjang
                Cart::where('user_id', $user->id)->delete();
                
                return $newOrder;
            });

            // 4. Logika Midtrans (Jika Metode Pembayaran bukan COD)
            if ($request->payment_method !== 'COD') {
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->invoice_number,
                        'gross_amount' => (int) $order->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'phone' => $request->phone,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);
            }

            // 5. Redirect ke Detail Order
            return redirect()->route('pelanggan.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}