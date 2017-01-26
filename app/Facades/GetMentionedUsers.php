<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GetMentionedUsers extends Facade
{

    protected static function getFacadeAccessor() {
        return 'GetMentionedUsers';
    }

}
