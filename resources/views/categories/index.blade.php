<x-blog-layout meta-title="Categories" meta-description="Descripción de la página de las Categorias">

<div class="mx-auto mt-4 max-w-6xl">
    <h1 class="my-4 text-center font-serif text-4xl font-extrabold text-sky-600 md:text-5xl">
        Categories
    </h1>

    @auth
        <div class="flex items-center justify-center">
            <a
                href="{{ route('categories.create') }}"
                class="group rounded-full bg-sky-600 p-2 text-sky-100 shadow-lg duration-300 hover:bg-sky-700 active:bg-sky-800"
            >
                <svg
                    class="h-6 w-6 duration-300 group-hover:rotate-12"
                    data-slot="icon"
                    fill="none"
                    stroke-width="1.5"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    ></path>
                </svg>
            </a>
        </div>
    @endauth

    <!-- Formulario de Ordenación -->
    <form action="{{ route('categories.index') }}" method="GET" class="mb-4 flex justify-center space-x-4">
        <!-- Selector de categorías -->
        <!--
        <div class="relative inline-block">
            <label for="category_id" class="block text-sm font-semibold text-gray-700">Categoría:</label>
            <select name="category_id" id="category_id" class="p-2 rounded border border-gray-300 bg-white shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="">Todas las categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        -->
        <div class="relative inline-block">
            <label for="search_category" class="block text-sm font-semibold text-gray-700">Buscar categoría:</label>
            <input type="text" name="search_category" id="search_category" value="{{ request('search_category') }}"
                   class="p-2 rounded border border-gray-300 bg-white shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                   placeholder="Buscar por categoría">
        </div>

        <!-- Selector de orden -->
        <div class="flex space-x-4 items-center">
            <!-- Selector de orden -->
            <div class="relative inline-block">
                <label for="order_by" class="block text-sm font-semibold text-gray-700">Ordenar por:</label>
                <select name="order_by" id="order_by" class="p-2 rounded border border-gray-300 bg-white shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="created_at" {{ $orderBy == 'created_at' ? 'selected' : '' }}>Fecha de creación</option>
                </select>
            </div>

            <!-- Selector de dirección -->
            <div class="relative inline-block">
                <label for="order_direction" class="block text-sm font-semibold text-gray-700">Dirección:</label>
                <select name="order_direction" id="order_direction" class="p-2 rounded border border-gray-300 bg-white shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="asc" {{ $orderDirection == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" {{ $orderDirection == 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>
            </div>
        </div>

        <!-- Botón de aplicar -->
        <button type="submit" class="text-lg font-semibold group flex items-center rounded-full bg-sky-600 px-3 py-2 text-sky-100 shadow-lg duration-300 hover:bg-sky-700 active:bg-sky-800">
            Ordenar
        </button>
    </form>

    <div class="mx-auto mt-8 grid max-w-6xl gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach($categories as $index => $category)
            <article
                class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900">
                <!--class="post-item flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900 {{ $index >= 9 ? 'hidden' : '' }}"-->
                <div class="flex-1 space-y-3 p-5">
                    <h2 class="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200">
                        <a class="hover:underline" href="{{ route('categories.show', $category) }}">
                            {{ $category->name }}
                        </a>
                    </h2>
                    <p class="hidden text-slate-500 dark:text-slate-400 md:block">
                        {{ $category->body }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>

</div>

<div class="flex items-center justify-center mt-1 space-x-2">
    <div>
        {{ $categories->appends(['order_by' => $orderBy, 'order_direction' => $orderDirection])->links() }}
    </div>
</div>
</x-blog-layout>
