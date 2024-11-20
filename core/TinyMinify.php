<?php
namespace Core;
use Core\TinyHtmlMinifier;

class TinyMinify
{
    public static function html(string $html, array $options = []) : string
    {
        $minifier = new TinyHtmlMinifier($options);
        return $minifier->minify_html($html);
    }
}
