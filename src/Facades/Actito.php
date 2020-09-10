<?php

namespace Cherrypulp\LaravelActito\Facades;

use Illuminate\Support\Facades\Facade;

class Actito extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-actito';
    }
}
