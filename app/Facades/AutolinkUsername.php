<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AutolinkUsername extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AutolinkUsername';
    }
}
