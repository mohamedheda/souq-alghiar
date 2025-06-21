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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('comments')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('post_id')->nullable()->constrained('posts')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('pinned')->default('0')->comment("0->not pinned , 1-> pinned");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
