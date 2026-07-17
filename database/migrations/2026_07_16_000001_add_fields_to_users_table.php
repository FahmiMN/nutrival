<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('email');
            $table->boolean('is_active')->default(true)->after('role');
            // Data tubuh untuk BMR/TDEE
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->decimal('height_cm', 5, 1)->nullable();
            $table->decimal('weight_kg', 5, 1)->nullable();
            $table->enum('activity_level', ['sedentary', 'light', 'moderate', 'active', 'very_active'])->nullable();
            $table->enum('goal', ['lose', 'maintain', 'gain'])->nullable();
            // Target harian
            $table->unsignedInteger('calorie_target')->nullable();
            $table->unsignedInteger('protein_target')->nullable();
            $table->unsignedInteger('carb_target')->nullable();
            $table->unsignedInteger('fat_target')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'is_active', 'birth_date', 'gender', 'height_cm', 'weight_kg',
                'activity_level', 'goal', 'calorie_target', 'protein_target', 'carb_target', 'fat_target',
            ]);
        });
    }
};
