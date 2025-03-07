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
        Schema::create('product_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('mark_id')->nullable()->constrained('marks')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('model_id')->nullable()->constrained('models')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->integer('year_from')->default(0);
            $table->integer('year_to')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_marks');
    }
};
