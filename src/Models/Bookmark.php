<?php

namespace Laravelir\Bookmarkable\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Laravelir\Bookmarkable\Models\BookmarkGroup;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookmark extends Model
{
    protected $table = 'bookmarkable_bookmarks';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
        });
    }

    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }

    public function bookmarker(): MorphTo
    {
        return $this->morphTo();
    }

    public function group()
    {
        return $this->belongsTo(BookmarkGroup::class);
    }
}
