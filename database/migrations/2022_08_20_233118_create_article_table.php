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
        Schema::dropIfExists('article');
        Schema::create('article', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->char('locale', 3)->default('en');
            $table->string('title');
            $table->string('slug');
            $table->text('brief')->nullable();
            $table->text('content');
            $table->char('layout', 64)->default('standard');
            $table->bigInteger('category_id', false, true)->nullable();
            $table->enum('status', ['active', 'inactive', 'pending', 'rejected', 'expired'])->default('pending');
            $table->dateTime('publish_at');
            $table->date('expire_at');
            $table->dateTime('created_at');
            $table->bigInteger('created_by',false, true)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by',false, true)->nullable();

            $table->index('locale');

            $table->foreign('category_id')->references('id')->on('category')->onUpdate('no action')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
