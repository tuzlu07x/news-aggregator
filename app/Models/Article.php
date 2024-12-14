<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;

    protected $fillable = ['title', 'content', 'category', 'source', 'published_at',];

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'source' => $this->source,
            'published_at' => $this->published_at,
        ];
    }

    public function searchableAs(): string
    {
        return 'articles';
    }
}
