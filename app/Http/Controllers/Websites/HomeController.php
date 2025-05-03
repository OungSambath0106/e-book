<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\Baner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('productgallery')->where('status', 1)->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();
        $banners = Baner::where('status', 1)->take(4)->orderBy('id', 'desc')->get();

        return view('website.home.index', compact('products', 'categories', 'banners'));
    }
}
