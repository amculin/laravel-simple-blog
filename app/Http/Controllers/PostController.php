<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Articles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            ->where('status', '=', Articles::IS_ACTIVE)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(5);

        return view('posts.index', $data);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        Articles::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'publish_at' => $request->publish_at,
            'status' => $request->convertStatus(),
            'author_id' => auth()->id(), // Assuming user is logged in
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
}
