<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $articles = Article::with('user:id,name')
            ->select('id', 'user_id', 'title', 'status', 'created_at')
            ->where('status', Article::IS_ACTIVE)
            ->latest('created_at')
            ->simplePaginate(5);

        return view('posts.index', ['articles' => $articles]);
    }

    public function show(string $id): View
    {
        return view('posts.show', [
            'post' => Article::findOrFail($id)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:60',
            'content' => 'required|string',
        ]);

        $model = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'publish_at' => $request->published_at,
            'status' => $request->is_draft,
            'user_id' => auth()->user()->id
        ]);

        if (is_null($request->published_at)) {
            $model->update([
                'publish_at' => $model->created_at
            ]);
        }

        return redirect()->route('home');
    }

    public function authorOnly(int $userId): bool
    {
        return Auth::check() && (auth()->user()->id === $userId);
    }

    public function edit(string $id): View|HttpException
    {
        $post = Article::findOrFail($id);

        abort_if(!$this->authorOnly($post->user_id), 403);
        
        return view('posts.edit', ['post' => $post]);
    }

    public function update(UpdatePostRequest $request, string $id): RedirectResponse|HttpException
    {
        $post = Article::findOrFail($id);

        abort_if(!$this->authorOnly($post->user_id), 403);
        
        $post->fill($request->validated());

        $post->publish_at = $request->published_at;
        $post->status = $request->is_draft;

        $post->save();
    
        return redirect()->route('home');
    }

    public function destroy(Article $post)
    {
        if (Auth::check() && (auth()->user()->id === $post->author_id)) {
            $post->delete();
            return redirect()->route('home')->with('success', 'Post deleted successfully!');
        } else {
            abort(403, 'Unauthorized access.');
        }
    }
}
