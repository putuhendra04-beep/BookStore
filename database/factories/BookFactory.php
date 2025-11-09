<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Category;

class BookFactory extends Factory {
    public function definition(): array {
        static $authorIds;
        static $categoryIds;

        $authorIds ??= Author::pluck('id')->toArray();
        $categoryIds ??= Category::pluck('id')->toArray();
        return [
            'judul'  => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'publisher' => $this->faker->company(),
            'author_id' => $this->faker->randomElement($authorIds),
            'category_id' => $this->faker->randomElement($categoryIds),
            'store_location' => $this->faker->randomElement(['JKT-01', 'DPS-01', 'SUB-01', 'LOM-01']),
            'availability_status' => $this->faker->randomElement(['available', 'rented', 'reserved']),
            'tahun_publis' => $this->faker->numberBetween(1950, 2025),
            'harga' => $this->faker->randomFloat(10, 50000, 300000),
            'avg_rating' => 0,
            'votes_count' => 0,
            'recent_popularity_score' => 0,
            'created_at' => now(),  
            'updated_at' => now(),
        ];
    }
}