<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $data['articles'] = Articles::with('author:id,name')
            ->select('id', 'author_id', 'title', 'status', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(5);

        return view('posts.index', $data);
    }
}
