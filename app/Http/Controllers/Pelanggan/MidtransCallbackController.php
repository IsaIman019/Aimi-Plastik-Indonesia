<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $orderId = str_replace('AIMI-', '', $request->order_id);
        $order = Order::findOrFail($orderId);

        if ($request->transaction_status === 'settlement') {

            $order->update(['status' => 'paid']);

            foreach ($order->items as $item) {
                Stock::where('product_id', $item->product_id)
                    ->decrement('quantity', $item->quantity);
            }
        }

        if (in_array($request->transaction_status, ['cancel','expire'])) {
            $order->update(['status' => 'cancelled']);
        }

        return response()->json(['success' => true]);
    }
}
