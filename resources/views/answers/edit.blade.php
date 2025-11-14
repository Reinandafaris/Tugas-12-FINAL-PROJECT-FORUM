<x-app-layout>
    <script src="https://cdn.tiny.cloud/1/hntkvjmwql6cm7ylsjn1nft5s0118rxyzvfm9rg7zaorfzn3/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jawaban') }}
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

                    <form action="{{ route('answers.update', $answer) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Isi Jawaban
                                Anda</label>
                            <textarea name="content" id="content" rows="6"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 tinymce-editor">{{ old('content', $answer->content) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('questions.show', $answer->question) }}"
                                class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update Jawaban
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
