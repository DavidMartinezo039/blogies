<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
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

        // Filtrar por título si se introduce una búsqueda
        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        // Filtrar por categoría si se selecciona una
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Ordenar según los parámetros seleccionados
        $orderBy = $request->get('order_by', 'published_at');
        $orderDirection = $request->get('order_direction', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        // Paginar los resultados
        $posts = $query->paginate(9);

        // Obtener todas las categorías para el desplegable en la vista


        // Pasar todas las variables a la vista
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
        // Validar los datos del formulario
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'published_at' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Asignar el user_id automáticamente desde el usuario autenticado
        $validated['user_id'] = auth()->id();

        // Crear el post con los datos validados, incluyendo el user_id
        Post::create($validated);

        // Redirigir a la lista de posts o a donde desees
        return redirect()->route('posts.index')
            ->with('status', 'Post created successfully');
    }


    public function edit(Post $post)
    {
        $categories = Category::all(); // Obtener todas las categorías
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        // Obtén los datos validados del formulario
        $validated = $request->validated();

        // Asegúrate de que el 'category_id' se incluya en los datos actualizados
        $validated['category_id'] = $validated['category_id'] ?? $post->category_id;

        // Actualiza el post con los datos validados
        $post->update(array_merge($validated, [
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
        // Obtener todas las categorías para el formulario
        $categories = Category::all();

        return view('posts.user', compact('posts', 'orderBy', 'orderDirection', 'categories'));
    }

}
