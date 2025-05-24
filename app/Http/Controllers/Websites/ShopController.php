<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->orderBy('id', 'desc')->paginate(12);
        $bestSellersProducts = Product::where('bestseller', 1)->orderBy('count_product_sale', 'desc')->take(3)->get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();

        $years = Product::selectRaw('YEAR(publish) as year')
            ->whereNotNull('publish')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $yearCounts = Product::selectRaw('YEAR(publish) as year, COUNT(*) as count')
            ->whereNotNull('publish')
            ->groupBy('year')
            ->pluck('count', 'year');

        return view('website.shop.index', compact('products', 'categories', 'bestSellersProducts', 'years', 'yearCounts'));
    }

    public function filterProducts(Request $request, $categoryId)
    {
        $query = Product::where('status', 1);

        // Filter by category
        if ($categoryId !== 'all') {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Filter by year
        if ($request->has('years') && is_array($request->years)) {
            $query->whereIn(DB::raw('YEAR(publish)'), $request->years);
        }

        // Filter by rating
        if ($request->has('ratings') && is_array($request->ratings)) {
            $query->whereIn('rating', $request->ratings);
        }

        // Sorting
        switch ($request->sort) {
            case 'promotion':
                $query->whereHas('promotions', function ($q) {
                    $q->where('status', 1);
                })->with('promotions');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'popularity':
                $query->orderBy('reviews', 'desc');
                break;
            case 'bestseller':
                $query->orderBy('count_product_sale', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc'); // default sorting
        }

        $products = $query->paginate(10);

        $html = '';
        foreach ($products as $book) {
            $html .= view('website.shop.partials.card_book', compact('book'))->render();
        }

        return response()->json([
            'html' => $html,
            'pagination' => $products->links()->render(),
            'count' => $products->total(),
            'firstItem' => $products->count() ? $products->firstItem() : 0,
            'lastItem' => $products->count() ? $products->lastItem() : 0
        ]);
    }

    public function bookDetail($id)
    {
        // dd(auth()->guard('customers')->user());
        $book = Product::with('promotions')->find($id);
        $relatedBooks = Product::where('status', 1)
            ->where('id', '!=', $id)
            ->with('promotions')
            ->whereHas('categories', function ($query) use ($book) {
                $query->whereIn('categories.id', $book->categories()->get()->pluck('id'));
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('website.shop.partials.book_detail', compact('book', 'relatedBooks'));
    }

    // public function addToCart(Request $request)
    // {
    //     try {
    //         // if (!auth()->guard('customers')->check()) {
    //         //     return response()->json(['success' => false, 'message' => 'Please login first'], 401);
    //         // }

    //         $product_id = $request->product_id;
    //         $quantity = $request->quantity ?? 1;

    //         $book = Product::findOrFail($product_id);

    //         $cartItem = CartItem::updateOrCreate(
    //             [
    //                 'customer_id' => 1,
    //                 'product_id' => $product_id
    //             ],
    //             [
    //                 'quantity' => DB::raw("quantity + $quantity"),
    //                 'price' => $book->price
    //             ]
    //         );

    //         return response()->json(['success' => true, 'message' => 'Added to cart']);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    //     }
    // }
    public function addToCart(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $quantity = $request->quantity ?? 1;

            $customer_id = auth()->guard('customers')->user()->id;

            $cartItem = CartItem::where('customer_id', $customer_id)
                                ->where('product_id', $product_id)
                                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'customer_id' => $customer_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ]);
            }

            // get cart count
            $cartCount = CartItem::where('customer_id', auth()->guard('customers')->user()->id)->count();

            return response()->json(['success' => true, 'message' => 'Added to cart', 'cart_count' => $cartCount]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function buyNow(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $quantity = $request->quantity ?? 1;

            $customer_id = auth()->guard('customers')->user()->id;

            $cartItem = CartItem::where('customer_id', $customer_id)
                ->where('product_id', $product_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'customer_id' => $customer_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Added to cart']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
