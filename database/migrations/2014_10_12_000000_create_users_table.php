<?php

use App\Http\Enums\UserType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type', UserType::values());
            $table->string('user_name')->unique()->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_blocked')->default(0);
            $table->boolean('otp_verified')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
