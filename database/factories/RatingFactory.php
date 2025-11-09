<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->value('id') ?? Book::factory(),
            'score' => $this->faker->numberBetween(1, 10),
            'comment' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
