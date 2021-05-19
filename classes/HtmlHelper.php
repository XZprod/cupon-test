<?php

namespace App;

class HtmlHelper
{
    public static function escape($text)
    {
        return htmlspecialchars($text);
    }
}