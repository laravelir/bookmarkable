<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarkable_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(config('social.bookmarks.bookmarker_foreign_key'))->index()->comment('user_id');
            $table->morphs(config('social.bookmarks.morphs'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarkable_bookmark_groups');
        Schema::dropIfExists('bookmarkable_bookmarks');
    }
};
