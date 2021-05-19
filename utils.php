<?php

function render($content, $params = [])
{
    extract($params, EXTR_OVERWRITE);
    require 'views/layout.php';
}

function renderPartial($view, $params = [])
{
    ob_start();
    extract($params, EXTR_OVERWRITE);
    require "views/{$view}.php";
    return ob_get_clean();
}