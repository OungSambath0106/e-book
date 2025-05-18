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
    public function index(Request $request)
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

    public function showAllBooks(Request $request)
    {
        $type = $request->query('type');

        $query = Product::where('status', 1);

        switch ($type) {
            case 'featured':
                $title = 'All Books';
                break;
            case 'bestseller':
                $query->where('bestseller', 1);
                $title = 'Best Seller Books';
                break;
            case 'new_arrival':
                $query->where('new_arrival', 1);
                $title = 'New Arrivals';
                break;
            case 'recommended':
                $query->where('recommended', 1);
                $title = 'Recommended Books';
                break;
            case 'popular':
                $query->where('popular', 1);
                $title = 'Popular Books';
                break;
            default:
                $title = 'All Books';
                // no filter
                break;
        }

        $books = $query->orderBy('id', 'desc')->get();

        return view('website.home.partials.all_books_show', compact('books', 'title', 'type'));
    }

    public function searchBooks(Request $request)
    {
        $search = $request->input('search');
        $books = Product::where('status', 1)
                        ->where('name', 'like', '%' . $search . '%')
                        ->orderBy('id', 'desc')
                        ->get();

        if ($request->ajax()) {
            return view('website.books.all_books_search', compact('books'));
        }

        return view('website.books.search_books', compact('books'));
    }
}
