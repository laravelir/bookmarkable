<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarkable_bookmark_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('bookmarkable_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->morphs('bookmarker'); // user
            $table->morphs('bookmarkable');
            $table->foreignId('group_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarkable_bookmark_groups');
        Schema::dropIfExists('bookmarkable_bookmarks');
    }
};
