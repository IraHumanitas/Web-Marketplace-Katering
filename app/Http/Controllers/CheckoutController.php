<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Merchant;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        // Total harga
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $customerId = auth()->user()->customer->id;

        // Ambil id merchant dari cart, jika ada
        $merchantId = $cart[array_key_first($cart)]['id_merchant'];

        // Data Order
        $order = new Order();
        $order->id_customer = $customerId;
        $order->id_merchant = $merchantId;
        $order->order_date = Carbon::now();
        $order->total_amount = $totalAmount;
        $order->status = 'pending'; // Default
        $order->save();

        // Data Invoice
        $invoice = new Invoice();
        $invoice->id_order = $order->id;
        $invoice->id_customer = $customerId;
        $invoice->date = Carbon::now();
        $invoice->due_date = Carbon::now()->addDays(7); // Contoh jatuh tempo dalam 7 hari
        $invoice->total_amount = $totalAmount;
        $invoice->status = 'unpaid'; // Default
        $invoice->invoice_number = 'INV-' . $order->id; // Contoh format nomor invoice
        $invoice->save();

        // Bersihkan cart setelah checkout berhasil
        Session::forget('cart');

        return redirect()->route('invoice.show', $invoice->id)->with('success', 'Order placed successfully!');
    }
}
