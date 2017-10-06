<?php

namespace App\Services;

class StringService
{
    /**
     * @var array
     */
    private $map = [
        'á' => 'a',
        'à' => 'a',
        'ã' => 'a',
        'â' => 'a',
        'é' => 'e',
        'ê' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ç' => 'c',
        ' ' => '-'
    ];

    /**
     * @param string $string
     * @param bool $toLower
     * @return string
     */
    public function toSlug($string, $toLower = true)
    {
        $string = trim($string);
        if ($toLower) {
            $string = strtolower($string);
        }

        return strtr($string, $this->map);
    }

}