<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10); // Ambil 10 data terbaru
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        // 2. Buat kategori baru
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-') // Otomatis buat slug
        ]);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // $category sudah otomatis di-inject oleh Laravel (route model binding)
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validasi data
        $request->validate([
            // 'unique' harus mengabaikan ID kategori saat ini
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // 2. Update kategori
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Hapus kategori
        $category->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
