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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->integer('price');
            $table->integer('months');
            $table->tinyInteger('products')->nullable();
            $table->tinyInteger('featured_products')->nullable();
            $table->tinyInteger('comments')->nullable();
            $table->tinyInteger('pinned_comments')->nullable();
            $table->text('promotional_text')->nullable();
            $table->tinyInteger('default_package')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
