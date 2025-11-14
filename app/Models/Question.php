<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    /**
     * Mendapatkan user yang membuat pertanyaan ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan kategori dari pertanyaan ini.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendapatkan jawaban-jawaban untuk pertanyaan ini.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    // Tambahkan juga $fillable
    protected $fillable = ['user_id', 'category_id', 'title', 'content', 'image'];
}
