<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Persistent cache of LLM translations for catalog free text.
     * Keyed by (lang, sha-256 of source text) so editing a course
     * naturally invalidates: new text hashes to a new key.
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 8);
            $table->string('source_hash', 64);
            $table->text('translation');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['lang', 'source_hash'], 'translations_lang_source_hash_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
