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
                                        class="inline ml-2 form-hapus"
                                        onsubmit="return confirm('Anda yakin ingin menghapus jawaban ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
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
