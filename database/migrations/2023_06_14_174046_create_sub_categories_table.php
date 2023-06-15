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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        DB::table('sub_categories')->insert([
            'title' => 'Action',
            'description' => 'ខ្សែភាពយន្តវាយប្រហារ',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Adventure',
            'description' => 'ខ្សែភាពយន្តផ្សងព្រេង',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Animation',
            'description' => 'ខ្សែភាពយន្តគំនូរជីវចល',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Comedy',
            'description' => 'ខ្សែភាពយន្តកំប្លែង',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Crime',
            'description' => 'ខ្សែភាពយន្តកាប់សម្លាប់',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Documentary',
            'description' => 'ខ្សែភាពយន្តឯកសារ',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Drama',
            'description' => 'ខ្សែភាពយន្តស្នេហា',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Family',
            'description' => 'ខ្សែភាពយន្តគ្រួសារ',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Fantasy',
            'description' => 'ខ្សែភាពយន្តបចេកវិទ្យា',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'History',
            'description' => 'ខ្សែភាពយន្តប្រវត្តិសាស្ត្រ',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Horror',
            'description' => 'ខ្សែភាពយន្តរន្ធត់',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Music',
            'description' => 'ខ្សែភាពយន្តតន្ត្រី',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Mystery',
            'description' => 'ខ្សែភាពយន្តដំណើរការមិនឃើញ',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Romance',
            'description' => 'ខ្សែភាពយន្តមនោសញ្ចេតនា',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Science Fiction',
            'description' => 'ខ្សែភាពយន្តវិទ្យាសាស្ត្រ',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'TV Movie',
            'description' => 'ខ្សែភាពយន្តចាក់បញ្ចាំងតាមទូរទស្សន៍',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Thriller',
            'description' => 'ខ្សែភាពយន្តកាប់សម្លាប់',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'War',
            'description' => 'ខ្សែភាពយន្តសង្គ្រាម',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'Western',
            'description' => 'ខ្សែភាពយន្តជនជាតិខាងជើង',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'BL',
            'description' => 'ខ្សែភាពយន្តស្នេហាប្រុសនិងប្រុស',
        ]);
        DB::table('sub_categories')->insert([
            'title' => 'GL',
            'description' => 'ខ្សែភាពយន្តស្នេហាស្រីនិងស្រី',
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
