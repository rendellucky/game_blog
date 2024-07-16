<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class PostServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'postService';
    }
}
