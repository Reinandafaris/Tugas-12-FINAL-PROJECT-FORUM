<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * Mendapatkan pertanyaan-pertanyaan dalam kategori ini.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    // Tambahkan juga $fillable untuk kemudahan CRUD nanti
    protected $fillable = ['name', 'slug'];
}
