<?php

namespace App;

class AutoLinkUsername
{

    public static function parse(string $body)
    {
        $url = env('APP_URL');
        return preg_replace('/\@\w+/', "[\\0]($url/user/profile/\\0)", $body);
    }
}
