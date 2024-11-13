<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name"
                  name="name"
                  type="text"
                  value="{{ old('name', $category->name) }}"
                  class="block w-full mt-1"
    />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="block w-full mt-1"
    >{{ old('body', $category->body) }}</x-textarea>
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>
