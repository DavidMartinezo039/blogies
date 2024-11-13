<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index(Request $request)
    {
        $query = Post::query();

        // Filtra por título si se introduce una búsqueda
        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        // Ordena según los parámetros seleccionados
        $orderBy = $request->get('order_by', 'published_at');
        $orderDirection = $request->get('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        $posts = $query->paginate(9);

        return view('posts.index', compact('posts', 'orderBy', 'orderDirection'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', ['post' => new Post()]);
    }

    public function store(StorePostRequest $request)
    {
        Post::create(array_merge($request->validated(), [
            'user_id' => auth()->id(),
        ]));
        return to_route('posts.index')
            ->with('status', 'Post created successfully');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function  update(UpdatePostRequest $request, Post $post)
    {
        $post->update(array_merge($request->validated(), [
            'user_id' => auth()->id(),
        ]));
        return to_route('posts.show', $post)
            ->with('status', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('posts.index')
            ->with('status', 'Post deleted successfully');
    }

    public function user(Request $request)
    {
        $userId = Auth::id();
        $orderBy = $request->input('order_by', 'published_at');
        $orderDirection = $request->input('order_direction', 'desc');

        // Cambia 'get()' por 'paginate()' para habilitar la paginación
        $posts = Post::where('user_id', $userId)
            ->orderBy($orderBy, $orderDirection)
            ->paginate(9);

        return view('posts.user', compact('posts', 'orderBy', 'orderDirection'));
    }

}
