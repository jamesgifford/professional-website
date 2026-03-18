<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('posts')
            ->whereNotNull('featured_image')
            ->update(['featured_image' => DB::raw("REPLACE(featured_image, 'images/featured/', '')")]);

        DB::table('projects')
            ->whereNotNull('featured_image')
            ->update(['featured_image' => DB::raw("REPLACE(featured_image, 'images/featured/', '')")]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('posts')
            ->whereNotNull('featured_image')
            ->update(['featured_image' => DB::raw("'images/featured/' || featured_image")]);

        DB::table('projects')
            ->whereNotNull('featured_image')
            ->update(['featured_image' => DB::raw("'images/featured/' || featured_image")]);
    }
};
