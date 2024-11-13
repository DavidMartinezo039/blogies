<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Muestra el formulario para crear una nueva categoría
    public function create()
    {
        return view('categories.create', ['category' => new Category()]);
    }

    // Almacena una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'user_id' => auth()->id(),  // El usuario que crea la categoría
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    // Muestra el formulario para editar una categoría
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Actualiza una categoría existente
    public function  update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update(array_merge($request->validated(), [
            'user_id' => auth()->id(),
        ]));
        return to_route('categories.show', $category)
            ->with('status', 'Category updated successfully');
    }

    // Elimina una categoría
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }

    // Muestra todas las categorías (opcional si quieres una lista)
    public function index(Request $request)
    {
        // Obtén todas las categorías
        $query = Category::query();

        // Filtro por nombre de categoría
        if ($request->filled('search_category')) {
            $query->where('name', 'like', '%' . $request->search_category . '%');
        }

        // Ordenación
        $orderBy = $request->get('order_by', 'name');  // Ordenar por nombre por defecto
        $orderDirection = $request->get('order_direction', 'asc');  // Ordenar ascendente por defecto
        $query->orderBy($orderBy, $orderDirection);

        $categories = $query->paginate(9); // Puedes ajustar el número de categorías por página

        return view('categories.index', compact('categories', 'orderBy', 'orderDirection'));
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
}
