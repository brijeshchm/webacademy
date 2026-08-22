<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proofs', function (Blueprint $table) {
            $table->id();
            $table->longText('image_data');
            $table->string('caption')->default('');
            $table->string('proof_date');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proofs');
    }
};
