<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->orderBy('id', 'desc')->paginate(12);
        $bestSellersProducts = Product::where('bestseller', 1)->orderBy('count_product_sale', 'desc')->take(3)->get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();

        return view('website.shop.index', compact('products', 'categories', 'bestSellersProducts'));
    }

    public function filterProducts(Request $request, $categoryId)
    {
        if ($categoryId == 'all') {
            $products = Product::where('status', 1)
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            $products = Product::where('status', 1)
                ->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                })
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        $html = '';
        foreach ($products as $book) {
            $html .= view('website.shop.partials.card_book', compact('book'))->render();
        }

        $pagination = $products->links()->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'count' => $products->total(),
            'firstItem' => $products->count() ? $products->firstItem() : 0,
            'lastItem' => $products->count() ? $products->lastItem() : 0
        ]);
    }

    public function bookDetail($id)
    {
        $book = Product::find($id);
        $relatedBooks = Product::where('status', 1)
            ->where('id', '!=', $id)
            ->whereHas('categories', function ($query) use ($book) {
                $query->whereIn('categories.id', $book->categories()->get()->pluck('id'));
            })
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('website.shop.partials.book_detail', compact('book', 'relatedBooks'));
    }
}
