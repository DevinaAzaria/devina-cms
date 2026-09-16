<?php

declare(strict_types=1);
namespace DevinaCms\Support;
final class Slug
{
    public static function make(string $value): string
    {
        $value = trim($value);
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if ($ascii !== false) $value = $ascii;
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/i', '-', $value) ?? '';
        $value = trim($value, '-');
        return $value !== '' ? strtolower($value) : 'item';
    }
}
