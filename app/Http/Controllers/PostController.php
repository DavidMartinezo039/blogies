<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
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
        $categories = Category::all();

        // Filtra por título si se introduce una búsqueda
        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        /*
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        */

        if ($request->filled('search_category')) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search_category . '%');
            });
        }


        // Ordena según los parámetros seleccionados
        $orderBy = $request->get('order_by', 'published_at');
        $orderDirection = $request->get('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        $posts = $query->paginate(9);

        return view('posts.index', compact('posts', 'orderBy', 'orderDirection', 'categories'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all(); // Obtener todas las categorías

        return view('posts.create', ['post' => new Post()], compact('categories'));
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
        $categories = Category::all(); // Obtener todas las categorías

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
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

        $query = Post::where('user_id', $userId);

        // Filtra por título si se introduce una búsqueda
        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        // Filtra por categoría si se selecciona una categoría
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Ordena según los parámetros seleccionados
        $query->orderBy($orderBy, $orderDirection);

        // Realiza la paginación
        $posts = $query->paginate(9);

        $categories = Category::all();

        return view('posts.user', compact('posts', 'orderBy', 'orderDirection', 'categories'));
    }

}
