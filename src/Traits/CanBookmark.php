<?php

namespace Laravelir\Bookmarkable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CanBookmark
{
    public function bookmarkModel(): string
    {
        return config('laravelir.bookmarkable.bookmarks.model');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany($this->bookmarkModel(), 'bookmarker');
    }

    public function bookmark(Model $model, $group_id = 0)
    {
        if (!$this->hasBookmarked($model)) {

            $attributes = [
                'bookmarkable_type' => $model->getMorphClass(),
                'bookmarkable_id' => $model->getKey(),
                'group_id' => $group_id
            ];

            return $this->bookmarks()->create($attributes);
        }
    }

    public function unBookmark(Model $model): bool
    {
        if ($this->hasBookmarked($model)) {
            $relation = $this->bookmarks()
                ->where('bookmarkable_id', $model->getKey())
                ->where('bookmarkable_type', $model->getMorphClass())
                ->first();

            if ($relation) {
                if ($this->relationLoaded('bookmarks')) {
                    $this->unsetRelation('bookmarks');
                }

                return $relation->delete();
            }

            return true;
        }

        return false;
    }

    public function toggleBookmark(Model $model)
    {
        return $this->hasBookmarked($model) ? $this->unBookmark($model) : $this->bookmark($model);
    }

    public function hasBookmarked(Model $model): bool
    {
        // return ($this->relationLoaded('bookmarks') ? $this->bookmarks : $this->bookmarks())

        return !! $this->bookmarks()
            ->where('bookmarkable_id', $model->getKey())
            ->where('bookmarkable_type', $model->getMorphClass())
            ->exists();
    }
}
