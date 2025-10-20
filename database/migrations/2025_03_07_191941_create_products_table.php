<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {


        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('used')->default('0')->comment("0->new 1->used");
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->nullable()->constrained('categories')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('sub_category_id')->nullable()->constrained('categories')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->integer("price")->default(0);
            $table->tinyInteger('all_makes')->default('0')->comment("0->specific makes , 1-> all makes");
            $table->tinyInteger('featured')->default('0')->comment("0->not featured makes , 1-> featured");
            $table->bigInteger('views')->default(0);

            $table->index('category_id');
            $table->index('sub_category_id');
            $table->index('user_id');
            $table->index('featured');
            $table->fullText(['title', 'description']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
