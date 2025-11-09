<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id', 'fk_ratings_books')->references('id')->on('books')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); 
            $table->string('guest_ip', 45)->nullable(); 
            $table->tinyInteger('score')->unsigned()->check('score BETWEEN 1 AND 10');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->index(['book_id', 'created_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('ratings');
    }
};