<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    /**
     * Mendapatkan user yang membuat jawaban ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan pertanyaan yang dijawab.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    // Tambahkan juga $fillable
    protected $fillable = ['user_id', 'question_id', 'content'];
}
