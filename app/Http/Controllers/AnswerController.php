<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Menyimpan jawaban baru ke database.
     */
    public function store(Request $request, Question $question)
    {
        // 1. Validasi
        $request->validate([
            'content' => 'required|string|min:5',
        ]);

        // 2. Buat jawaban
        $question->answers()->create([
            'user_id' => Auth::id(),
            'content' => clean($request->content),
        ]);

        // 3. Redirect kembali ke halaman pertanyaan
        return redirect()->route('questions.show', $question)
            ->with('success', 'Jawaban berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit jawaban.
     */
    public function edit(Answer $answer)
    {
        // 1. Otorisasi
        $this->authorize('update', $answer);

        // 2. Tampilkan view
        return view('answers.edit', compact('answer'));
    }

    /**
     * Update jawaban di database.
     */
    public function update(Request $request, Answer $answer)
    {
        // 1. Otorisasi
        $this->authorize('update', $answer);

        // 2. Validasi
        $request->validate([
            'content' => 'required|string|min:5',
        ]);

        // 3. Update jawaban
        $answer->update([
            'content' => clean($request->content),
        ]);

        // 4. Redirect kembali ke halaman pertanyaan (question.show)
        return redirect()->route('questions.show', $answer->question)
            ->with('success', 'Jawaban berhasil diperbarui.');
    }


    /**
     * Menghapus jawaban dari database.
     */
    public function destroy(Answer $answer)
    {
        // 1. Otorisasi
        $this->authorize('delete', $answer);

        // Simpan question_id sebelum dihapus untuk redirect
        $questionId = $answer->question_id;

        // 2. Hapus jawaban
        $answer->delete();

        // 3. Redirect kembali ke halaman pertanyaan
        return redirect()->route('questions.show', $questionId)
            ->with('success', 'Jawaban berhasil dihapus.');
    }
}
