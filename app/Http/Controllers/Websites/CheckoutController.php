<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index($page = 'cart')
    {
        $cartItems = CartItem::with('product')
                    ->with('product.promotions')
                    ->where('customer_id', auth()
                    ->guard('customers')
                    ->id())
                    ->get();
        $cart = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'title' => $item->product->title,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'promotions' => $item->product->promotions->map(function ($promotion) {
                    return [
                        'id' => $promotion->id,
                        'percent' => $promotion->percent,
                        'amount' => $promotion->amount,
                        'discount_type' => $promotion->discount_type,
                    ];
                }),
            ];
        });

        $shippingAddresses = ShippingAddress::where('customer_id', auth()->guard('customers')
                        ->id())
                        ->orderBy('id', 'desc')
                        ->get();

        return view('website.checkout.index', compact('cartItems', 'cart', 'page', 'shippingAddresses'));
    }

    public function cart()
    {
        $cartItems = CartItem::with('product')->where('customer_id', auth()->guard('customers')->id())->get();

        return view('website.checkout.partials.cart_page', compact('cartItems'));
    }

    public function updateQuantity(Request $request)
    {
        $cartItem = CartItem::where('product_id', $request->product_id)
            ->where('customer_id', auth()->guard('customers')->id())
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // get cart count
            $cartCount = CartItem::where('customer_id', auth()->guard('customers')->id())->sum('quantity');

            return response()->json(['success' => true, 'cart_count' => $cartCount]);
        }

        return response()->json(['success' => false], 404);
    }

    public function removeItem(Request $request)
    {
        $cartItem = CartItem::where('id', $request->id)
            ->where('customer_id', auth()->guard('customers')->id())
            ->first();

        if ($cartItem) {
            $cartItem->delete();

            // get cart count
            $cartCount = CartItem::where('customer_id', auth()->guard('customers')->id())->count();

            return response()->json(['success' => true, 'cart_count' => $cartCount, 'message' => 'Item removed from cart']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    public function saveAddress(Request $request)
    {
        $customer = auth()->guard('customers')->user();

        if ($request->save_address) {
            $existingAddress = $customer->shippingAddresses()
                ->where('label', $request->label)
                ->where('email', $request->email)
                ->where('address', $request->address)
                ->where('phone', $request->phone)
                ->first();

            if ($existingAddress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Address already exists'
                ]);
            }

            // Save the new address
            $customer->shippingAddresses()->create([
                'label' => $request->label,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'phone' => $request->phone
            ]);
        }

        $shippingAddresses = $customer->shippingAddresses;

        return response()->json([
            'success' => true,
            'message' => 'Address saved',
            'data' => $shippingAddresses
        ]);
    }
}
