<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('website.checkout.index');
    }

    public function cart()
    {
        $cartItems = CartItem::with('product')->where('customer_id', auth()->guard('customer')->id())->get();

        return view('website.checkout.partials.cart_page', compact('cartItems'));
    }
}
