<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forum Tanya Jawab') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('questions.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Buat Pertanyaan Baru
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        @forelse ($questions as $question)
                            <div class="p-4 border rounded-lg">
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('questions.show', $question) }}"
                                        class="text-lg font-semibold text-indigo-600 hover:text-indigo-800">{{ $question->title }}</a>
                                    <span class="text-sm text-gray-500">
                                        {{ $question->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    Ditanyakan oleh: <strong>{{ $question->user->name }}</strong>
                                    Kategori: <span class="font-medium">{{ $question->category->name }}</span>
                                </div>
                                <div class="mt-2 text-gray-700">
                                    {{ Str::limit($question->content, 150) }}
                                </div>
                                @canany(['update', 'delete'], $question)
                                    <div class="mt-3 text-right">
                                        @can('update', $question)
                                            <a href="{{ route('questions.edit', $question) }}"
                                                class="text-sm text-yellow-600 hover:text-yellow-800">Edit</a>
                                        @endcan
                                        @can('delete', $question)
                                            <form action="{{ route('questions.destroy', $question) }}" method="POST"
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
                        @empty
                            <p class="text-gray-500">Belum ada pertanyaan.</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $questions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
