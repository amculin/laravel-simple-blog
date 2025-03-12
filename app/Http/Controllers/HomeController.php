<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $data = [];

        if (Auth::check()) {
            $data['articles'] = Articles::where('author_id', '=', Auth::id())
                ->orderBy('created_at', 'DESC')
                ->simplePaginate(5);
        }

        return view('home', $data);
    }
}
