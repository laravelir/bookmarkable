<?php

namespace Laravelir\Bookmarkable\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Laravelir\Bookmarkable\Models\Bookmark;

class BookmarkGroup extends Model
{
    protected $table = 'bookmarkable_bookmark_groups';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::uuid4();
        });
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Bookmark::class);
    }
}
