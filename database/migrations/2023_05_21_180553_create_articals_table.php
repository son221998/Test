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
        Schema::create('articals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumnail');
            $table->text('content');
            $table->string('author');
            $table->string('category_id');
            $table->string('tag_id');
            $table->string('type_id');
            $table->string('origin');
            $table->integer('like')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articals');
    }
    
};
