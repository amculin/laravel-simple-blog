<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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

    public function show(Articles $post)
    {
        return view('posts.show', compact('post'));
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
            'publish_at' => $request->published_at ? $request->published_at : date('Y-m-d H:i:s'),
            'status' => $request->convertStatus(),
            'author_id' => auth()->id()
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    public function edit(Articles $post)
    {
        if (Auth::check() && (auth()->user()->id === $post->author_id)) {
            return view('posts.edit', compact('post'));
        } else {
            abort(403, 'Unauthorized access.');
        }
    }

    public function update(UpdatePostRequest $request, Articles $post)
    {
        if (Auth::check() && (auth()->user()->id === $post->author_id)) {
            $post->status = $request->convertStatus();
            $post->publish_at = $request->published_at ? $request->published_at : date('Y-m-d H:i:s');
    
            $post->update($request->validated());
    
            return redirect()->route('home')->with('success', 'Post updated successfully!');
        } else {
            abort(403, 'Unauthorized access.');
        }
    }

    public function destroy(Articles $post)
    {
        if (Auth::check() && (auth()->user()->id === $post->author_id)) {
            $post->delete();
            return redirect()->route('home')->with('success', 'Post deleted successfully!');
        } else {
            abort(403, 'Unauthorized access.');
        }
    }
}
