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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->text('description')->nullable();
            $table->foreignId('mark_id')->nullable()->constrained('marks')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('model_id')->nullable()->constrained('models')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->nullable()->constrained('categories')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->nullable()->constrained('cities')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->integer('year')->default(0);

            $table->fullText('description');
            $table->index('category_id');
            $table->index('mark_id');
            $table->index('model_id');
            $table->index('city_id');
            $table->index('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
