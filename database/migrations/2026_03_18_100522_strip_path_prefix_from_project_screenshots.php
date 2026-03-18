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
        DB::table('project_screenshots')
            ->update(['path' => DB::raw("REPLACE(path, 'images/screenshots/', '')")]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('project_screenshots')
            ->update(['path' => DB::raw("'images/screenshots/' || path")]);
    }
};
