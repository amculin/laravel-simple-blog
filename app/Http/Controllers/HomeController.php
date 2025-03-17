<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $articles = null;

        if (Auth::check()) {
            $articles = Article::where('user_id', Auth::id())
                ->latest('created_at')
                ->simplePaginate(5);
        }

        return view('home', ['articles' => $articles]);
    }
}
