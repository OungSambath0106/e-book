<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('website.authors.index', compact('authors'));
    }

    public function show($id)
    {
        $author = Author::find($id);
        return view('website.authors.partials.author_detail', compact('author'));
    }
}
