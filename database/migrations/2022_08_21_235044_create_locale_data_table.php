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
        Schema::create('locale_data', function (Blueprint $table) {
            $table->id();
            $table->char('locale', 3)->default('en');
            $table->char('section', 64);
            $table->bigInteger('entry_id', false, true);
            $table->char('name', 64);
            $table->text('content');

            $table->index(['entry_id', 'section', 'locale', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('locale_data');
    }
};
