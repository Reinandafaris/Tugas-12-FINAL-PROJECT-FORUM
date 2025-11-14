<x-app-layout>
    <script src="https://cdn.tiny.cloud/1/hntkvjmwql6cm7ylsjn1nft5s0118rxyzvfm9rg7zaorfzn3/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('questions.update', $question) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul
                                Pertanyaan</label>
                            <input type="text" name="title" id="title"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300"
                                value="{{ old('title', $question->title) }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select name="category_id" id="category_id"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $question->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Isi Pertanyaan</label>
                            <textarea name="content" id="content" rows="6"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 tinymce-editor">{{ old('content', $question->content) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">Ganti Gambar
                                (Opsional)</label>
                            <input type="file" name="image" id="image"
                                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @if ($question->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar saat ini"
                                        class="w-48 h-auto rounded">
                                    <span class="text-xs text-gray-500">Gambar saat ini. Mengupload gambar baru akan
                                        menggantikannya.</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('questions.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | table | code',
            height: 350
        });
    </script>
</x-app-layout>
