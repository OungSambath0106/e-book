<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\Baner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured_products = Product::where('status', 1)
                            ->orderBy('id', 'desc')
                            ->take(4)->get();
        $new_arrivals = Product::where('status', 1)
                            ->where('new_arrival', 1)
                            ->orderBy('id', 'desc')
                            ->paginate(4);
        $recommended = Product::where('status', 1)
                            ->where('recommended', 1)
                            ->orderBy('id', 'desc')
                            ->paginate(4);
        $popular = Product::where('status', 1)
                            ->where('popular', 1)
                            ->orderBy('id', 'desc')
                            ->paginate(4);
        $best_sellers = Product::where('status', 1)
                            ->where('bestseller', 1)
                            ->orderBy('id', 'desc')
                            ->paginate(4);
        $categories = Category::where('status', 1)
                            ->orderBy('id', 'desc')
                            ->get();
        $banners = Baner::where('status', 1)
                            ->orderBy('id', 'desc')
                            ->get();
        $promotions = Promotion::where('status', 1)
                            ->orderBy('id', 'desc')
                            ->get();

        return view('website.home.index', compact('featured_products', 'categories', 'banners', 'promotions', 'new_arrivals', 'recommended', 'popular', 'best_sellers'));
    }
}
