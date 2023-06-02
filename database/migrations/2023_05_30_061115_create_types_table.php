<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        //create type table
        DB::table('types')->insert([
            'name' => 'artical',
            'description' => 'artical',
        ]);
        DB::table('types')->insert([
            'name' => 'trailer',
            'description' => 'trailer',
        ]);
        DB::table('types')->insert([
            'name' => 'tv',
            'description' => 'tv',
        ]);
        DB::table('types')->insert([
            'name' => 'movie',
            'description' => 'movie',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
