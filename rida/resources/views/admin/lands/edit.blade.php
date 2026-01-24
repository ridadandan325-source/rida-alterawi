<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Admin • Edit Land</h2>
        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Edit any land in the system.</p>
      </div>
      <a href="{{ route('admin.lands.index') }}" class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-gray-50 dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
        Back
      </a>
    </div>
  </x-slot>

  <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:bg-white/5 dark:border-white/10">
    @if ($errors->any())
      <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-900 dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-200">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.lands.update', $land) }}" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label class="block mb-1 font-semibold">Title</label>
        <input name="title" value="{{ old('title', $land->title) }}"
               class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 dark:bg-white/5 dark:border-white/10 dark:text-white" required>
      </div>

      <div>
        <label class="block mb-1 font-semibold">Description</label>
        <textarea name="description" rows="3"
                  class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 dark:bg-white/5 dark:border-white/10 dark:text-white">{{ old('description', $land->description) }}</textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="block mb-1 font-semibold">Price</label>
          <input name="price" type="number" step="0.01" value="{{ old('price', $land->price) }}"
                 class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 dark:bg-white/5 dark:border-white/10 dark:text-white" required>
        </div>

        <div>
          <label class="block mb-1 font-semibold">Owner</label>
          <select name="user_id"
                  class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 dark:bg-white/5 dark:border-white/10 dark:text-white">
            @foreach($users as $u)
              <option value="{{ $u->id }}" {{ (int)old('user_id', $land->user_id) === (int)$u->id ? 'selected' : '' }}>
                {{ $u->name }} ({{ $u->email }})
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="block mb-1 font-semibold">Lat</label>
          <input name="lat" value="{{ old('lat', $land->lat) }}"
                 class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 dark:bg-white/5 dark:border-white/10 dark:text-white" required>
        </div>
        <div>
          <label class="block mb-1 font-semibold">Lng</label>
          <input name="lng" value="{{ old('lng', $land->lng) }}"
                 class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 dark:bg-white/5 dark:border-white/10 dark:text-white" required>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <input type="checkbox" name="is_for_sale" value="1" {{ old('is_for_sale', $land->is_for_sale) ? 'checked' : '' }}>
        <label class="font-semibold">For Sale</label>
      </div>

      <button class="inline-flex items-center rounded-2xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:opacity-90 dark:bg-white dark:text-black">
        Save (Admin)
      </button>
    </form>
  </div>
</x-app-layout>
