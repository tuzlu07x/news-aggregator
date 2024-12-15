<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence,
            'content' => $this->faker->paragraph,
            'category' => $this->faker->word,
            'author' => $this->faker->name,
            'source' => $this->faker->url,
            'published_at' => $this->faker->dateTime,
        ];
    }
}
