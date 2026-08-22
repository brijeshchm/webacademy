<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('company');
            $table->text('quote');
            $table->float('rating')->default(5);
            $table->string('avatar_url')->default('');
            $table->string('source')->default('other');
            $table->boolean('visible')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
