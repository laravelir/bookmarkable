<?php

namespace Laravelir\Bookmarkable\Facades;

use Illuminate\Support\Facades\Facade;

class Bookmarkable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bookmarkable';
    }
}
