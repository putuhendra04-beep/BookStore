<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->index();
            $table->string('isbn')->nullable()->index();
            $table->string('publisher')->nullable()->index();
            $table->foreignId('author_id')->constrained('authors', 'id')->onDelete('cascade')->index('books_author_idx');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->onDelete('cascade')->index('books_category_idx');
            $table->string('store_location')->nullable()->index();
            $table->enum('availability_status', ['available', 'rented', 'reserved'])->default('available')->index();
            $table->integer('tahun_publis')->nullable()->index();
            $table->decimal('harga', 10, 2)->nullable();
            $table->float('avg_rating')->default(0)->index();
            $table->unsignedInteger('votes_count')->default(0)->index();
            $table->float('recent_popularity_score')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('books');
    }
};
