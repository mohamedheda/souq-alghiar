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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('show_home')->default(0);
            $table->timestamps();
            $table->index('parent_id');
            $table->index('show_home');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
