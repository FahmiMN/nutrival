<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();

            // Porsi standar
            $table->decimal('serving_size', 8, 1)->default(100);    // angka, mis. 100
            $table->string('serving_unit')->default('gram');        // gram, ml, potong, dll
            $table->string('serving_text')->nullable();             // "1 mangkuk sedang"

            // Nutrisi per porsi standar (wajib)
            $table->decimal('calories', 8, 1);
            $table->decimal('protein', 8, 1)->default(0);
            $table->decimal('carbs', 8, 1)->default(0);
            $table->decimal('fat', 8, 1)->default(0);

            // Nutrisi tambahan (opsional)
            $table->decimal('fiber', 8, 1)->nullable();
            $table->decimal('sugar', 8, 1)->nullable();
            $table->decimal('sodium', 8, 1)->nullable();      // mg
            $table->decimal('cholesterol', 8, 1)->nullable(); // mg
            $table->decimal('saturated_fat', 8, 1)->nullable();

            // Custom food & approval
            $table->boolean('is_custom')->default(false);
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('approved');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
