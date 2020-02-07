<?php

namespace App\Application\Helper;

class ParseHelper
{
    public static function toBase62($num)
    {
        $b = 62;
        $base = 'IPj68uxh2iZztmsvOo1M5wVrcQWFTKbkLpal4SyJn0DE39R7XfNeBqHGdAUYgC';
        $r = $num % $b ;
        $res = $base[$r];
        $q = floor($num/$b);
        while ($q) {
            $r = $q % $b;
            $q = floor($q/$b);
            $res = $base[$r].$res;
        }
        return $res;
    }

    public static function toBase10($num)
    {
        $b = 62;
        $base = 'IPj68uxh2iZztmsvOo1M5wVrcQWFTKbkLpal4SyJn0DE39R7XfNeBqHGdAUYgC';
        $limit = strlen($num);
        $res = strpos($base, $num[0]);
        for ($i = 1; $i < $limit; $i++) {
            $res = $b * $res + strpos($base, $num[$i]);
        }
        return $res;
    }
}
