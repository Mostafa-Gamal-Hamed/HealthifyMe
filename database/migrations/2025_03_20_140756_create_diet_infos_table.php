<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diet_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('age')->nullable();
            $table->enum('gender', ["male", "female"])->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->enum('activity_level', ['low', 'moderate', 'high', 'professional'])->nullable();
            $table->integer('workout_hours_per_week')->default(0);
            $table->float('bodyFat')->nullable();
            $table->float('bodyWater')->nullable();
            $table->enum('target', ['weight loss','weight stabilization','weight gain','increased muscle'])->nullable();
            $table->text('diseases')->nullable();
            $table->text('treatment')->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_infos');
    }
};
