<?php

namespace App\Services;

use Parsedown;

class MarkDown
{
    public static function parse($md)
    {
        $pd = new Parsedown();
        return $pd->text(strip_tags($md));
    }

    public static function lite($md)
    {
        $pd = new Parsedown();
        $html = $pd->text(strip_tags($md));

        $strip = ['<p>', '</p>'];
        $html = str_replace($strip, '', $html);

        return $html;
    }
}
