<?php

namespace Laravelir\Bookmarkable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Bookmarkable
{
    public function bookmarkModel(): string
    {
        return config('laravelir.bookmarkable.bookmarks.model');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany($this->bookmarkModel(), 'bookmarkable');
    }

    public function bookmarkBy(Model $user, $group_id = 0)
    {
        if (!$this->isBookmarkedBy($user)) {

            $attributes = [
                'bookmarker_id' => $user->getMorphClass(),
                'bookmarker_type' => $user->getKey(),
                'group_id' => $group_id
            ];

            return $this->bookmarks()->create($attributes);
        }
    }

    public function isBookmarkedBy(Model $user): bool
    {
        return !! $this->bookmarks()
            ->where('bookmarker_id', $user->id)
            ->where('bookmarker_type', $user->getMorphClass())
            ->exists();
    }

    public function getBookmarksCountAttribute()
    {
        return $this->bookmarks()->count();
    }
}
