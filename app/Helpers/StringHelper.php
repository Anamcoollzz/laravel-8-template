<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StringHelper
{

    /**
     * get acronym from string
     *
     * @param string $words
     * @return string
     */
    public static function acronym(string $words, int $max = -1)
    {
        $words = explode(" ", $words);
        $acronym = "";
        if ($max === -1)
            foreach ($words as $w) {
                $acronym .= $w[0];
            }
        else {
            $i = 1;
            foreach ($words as $w) {
                $acronym .= $w[0];
                if ($i === $max) break;
                $i++;
            }
        }
        return $acronym;
    }

    /**
     * isUrl
     *
     * @param string $words
     * @return boolean
     */
    public static function isUrl(string $words)
    {
        return Str::contains($words, 'https://') || Str::contains($words, 'http://');
    }
}
