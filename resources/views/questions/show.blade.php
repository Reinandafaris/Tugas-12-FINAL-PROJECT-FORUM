<x-app-layout>
    <script src="https://cdn.tiny.cloud/1/hntkvjmwql6cm7ylsjn1nft5s0118rxyzvfm9rg7zaorfzn3/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $question->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-sm text-gray-600 mb-2">
                        Ditanyakan oleh: <strong>{{ $question->user->name }}</strong>
                        ({{ $question->created_at->format('d M Y, H:i') }})
                        Kategori: <span class="font-medium">{{ $question->category->name }}</span>
                    </div>

                    <div class="prose max-w-none text-gray-800">
                        {!! nl2br(e($question->content)) !!}
                    </div>

                    @if ($question->image)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar pertanyaan"
                                class="max-w-full h-auto rounded-lg border">
                        </div>
                    @endif

                    @canany(['update', 'delete'], $question)
                        <div class="mt-4 pt-4 border-t text-right">
                            @can('update', $question)
                                <a href="{{ route('questions.edit', $question) }}"
                                    class="text-sm text-yellow-600 hover:text-yellow-800">Edit Pertanyaan</a>
                            @endcan
                            @can('delete', $question)
                                <form action="{{ route('questions.destroy', $question) }}" method="POST"
                                    class="inline ml-2 form-hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800">Hapus
                                        Pertanyaan</button>
                                </form>
                            @endcan
                        </div>
                    @endcanany
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                    {{ $question->answers->count() }} Jawaban
                </h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-4">
                    @forelse ($question->answers as $answer)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between items-start">
                                    <div class="text-sm text-gray-600 mb-2">
                                        Dijawab oleh: <strong>{{ $answer->user->name }}</strong>
                                        ({{ $answer->created_at->diffForHumans() }})
                                    </div>

                                    @canany(['update', 'delete'], $answer)
                                        <div classs="flex-shrink-0 ml-4">
                                            @can('update', $answer)
                                                <a href="{{ route('answers.edit', $answer) }}"
                                                    class="text-sm text-yellow-600 hover:text-yellow-800">Edit</a>
                                            @endcan
                                            @can('delete', $answer)
                                                <form action="{{ route('answers.destroy', $answer) }}" method="POST"
                                                    class="inline ml-2 form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                                                </form>
                                            @endcan
                                        </div>
                                    @endcanany
                                </div>

                                <div class="prose max-w-none text-gray-700">
                                    {!! nl2br(e($answer->content)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-500">
                                Belum ada jawaban untuk pertanyaan ini.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Tulis Jawaban Anda
                    </h3>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('answers.store', $question) }}" method="POST">
                        @csrf
                        <div>
                            <label for="content_answer" class="sr-only">Isi Jawaban</label>
                            <textarea name="content" id="content_answer" rows="5"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 tinymce-editor"
                                placeholder="Tulis jawaban Anda di sini..." required>{{ old('content') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Kirim Jawaban
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#content_answer',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | table | code',
            height: 350
        });
    </script>
</x-app-layout>
