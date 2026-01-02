<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class CallbackController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            // 2. Ambil Notifikasi dari Midtrans
            $notification = new Notification();
            
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraud = $notification->fraud_status;

            // 3. Cari Order di Database (Berdasarkan Invoice Number)
            // Midtrans mengirim order_id sesuai invoice yang kita kirim saat checkout
            $order = Order::where('invoice_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // 4. Logika Status Pembayaran
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['status' => 'pending']);
                    } else {
                        $order->update(['status' => 'processed']); // Lunas (Kartu Kredit)
                    }
                }
            } else if ($transaction == 'settlement') {
                // Lunas (Transfer Bank, GoPay, QRIS, dll)
                $order->update(['status' => 'processed']); 
            } else if ($transaction == 'pending') {
                $order->update(['status' => 'pending']);
            } else if ($transaction == 'deny') {
                $order->update(['status' => 'cancelled']);
            } else if ($transaction == 'expire') {
                $order->update(['status' => 'cancelled']);
            } else if ($transaction == 'cancel') {
                $order->update(['status' => 'cancelled']);
            }

            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}