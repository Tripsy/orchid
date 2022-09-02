<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('locale_slug', function (Blueprint $table) {
            $table->id();
            $table->char('locale', 3)->default('en');
            $table->char('section', 64);
            $table->bigInteger('entry_id', false, true);
            $table->char('content', 64);

            $table->unique(['section', 'locale', 'content']);
            $table->unique(['entry_id', 'section', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('locale_slug');
    }
};
