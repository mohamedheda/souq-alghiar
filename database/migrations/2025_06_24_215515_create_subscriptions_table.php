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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('package_id')->nullable()->constrained('packages')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->integer('price')->default(0);
            $table->integer('months');
            $table->tinyInteger('products')->nullable();
            $table->tinyInteger('featured_products')->nullable();
            $table->tinyInteger('comments')->nullable();
            $table->tinyInteger('pinned_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
