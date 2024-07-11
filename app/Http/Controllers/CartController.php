<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Invoice;
use Carbon\Carbon;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $menuId = $request->input('id_menu');
        $quantity = $request->input('quantity');

        $menu = Menu::findOrFail($menuId);

        $cart = Session::get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += $quantity;
        } else {
            $cart[$menuId] = [
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => $quantity,
                'photo' => $menu->photo
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => 'Menu added to cart!']);
    }


    public function viewCart()
    {
        $cart = Session::get('cart', []);

        return view('customer.belanja.cart', compact('cart'));
    }

    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);

        unset($cart[$id]);

        Session::put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Menu removed from cart!');
    }

    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        // Hitung total harga 
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $customerId = auth()->user()->customer->id;

        foreach ($cart as $item) {
            $order = new Order();
            $order->id_customer = $customerId;
            $order->order_date = Carbon::now();
            $order->total_amount = $item['price'] * $item['quantity'];
            $order->status = 'pending'; 
            $order->save();

            $invoice = new Invoice();
            $invoice->id_order = $order->id;
            $invoice->id_customer = $customerId;
            $invoice->date = Carbon::now();
            $invoice->due_date = Carbon::now()->addDays(7); 
            $invoice->total_amount = $item['price'] * $item['quantity'];
            $invoice->status = 'unpaid'; 
            $invoice->invoice_number = 'INV-' . $order->id; 
            $invoice->save();
        }

        Session::forget('cart');

        return redirect()->route('invoice.show', ['id' => $invoice->id]);
    }

}
