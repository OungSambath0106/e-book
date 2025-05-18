<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();

        return view('website.categories.index', compact('products', 'categories'));
    }

    public function filterProducts($categoryId)
    {
        if ($categoryId == 'all') {
            $products = Product::where('status', 1)->orderBy('id', 'desc')->get();
        } else {
            $products = Product::where('status', 1)
                ->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                })
                ->orderBy('id', 'desc')
                ->get();
        }

        $html = '';
        foreach ($products as $book) {
            $html .= view('website.categories.partials.card_book', compact('book'))->render();
        }

        return response()->json(['html' => $html]);
    }
}
