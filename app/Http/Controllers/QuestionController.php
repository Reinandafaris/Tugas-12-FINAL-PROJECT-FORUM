<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data pertanyaan, urutkan dari terbaru
        // Eager load relasi 'user' dan 'category' untuk optimasi query
        $questions = Question::with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kita perlu mengirim daftar kategori ke view
        $categories = Category::orderBy('name')->get();
        return view('questions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        // 2. Handle Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan gambar di 'public/question_images'
            $imagePath = $request->file('image')->store('question_images', 'public');
        }

        // 3. Buat pertanyaan
        Question::create([
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => clean($request->content),
            'image' => $imagePath,
        ]);

        // 4. Redirect
        return redirect()->route('questions.index')
            ->with('success', 'Pertanyaan berhasil dipublikasikan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        // Eager load relasi 'user', 'category', dan 'answers'
        // Kita juga eager load 'user' dari 'answers'
        $question->load(['user', 'category', 'answers.user']);

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        // 1. Otorisasi! Cek apakah user ini boleh edit
        $this->authorize('update', $question);

        // 2. Kirim data kategori dan pertanyaan ke view
        $categories = Category::orderBy('name')->get();
        return view('questions.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        // 1. Otorisasi!
        $this->authorize('update', $question);

        // 2. Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $question->image;
        // 3. Handle Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('question_images', 'public');
        }

        // 4. Update pertanyaan
        $question->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => clean($request->content),
            'image' => $imagePath,
        ]);

        // 5. Redirect
        return redirect()->route('questions.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // 1. Otorisasi!
        $this->authorize('delete', $question);

        // 2. Hapus gambar terkait (jika ada)
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        // 3. Hapus pertanyaan
        $question->delete();

        // 4. Redirect
        return redirect()->route('questions.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
