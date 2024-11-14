<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title"
                  name="title"
                  type="text"
                  value="{{ old('title', $post->title) }}"
                  class="block w-full mt-1"
    />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>
<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="block w-full mt-1"
    >{{ old('body', $post->body) }}</x-textarea>
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>
<div>
    <x-input-label for="published_at" :value="__('Published')"/>
    <input type="date" id="published_at" name="published_at" class="block w-full mt-1"
           value="{{ old('published_at', $post->published_at) }}">
    <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
</div>
<!-- Selección de Categoría -->
<div>
    <x-input-label for="category_id" :value="__('Category')" />
    <select id="category_id" name="category_id" class="block w-full mt-1">
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>
