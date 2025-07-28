<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryEmbedding extends Model
{
    protected $fillable = ['category_id', 'embedding'];

    protected $casts = [
        'embedding' => 'array',
    ];

    protected $table="category_embeddings";

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
