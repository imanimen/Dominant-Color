<?php

namespace App\Http\Services;


class ColorService
{
    public function getDominantColor($image, $mimeType, $array = false, $format = 'rgb(%d, %d, %d)')
    {

        if ($mimeType == 'image/jpg' || $mimeType == 'image/jpeg')
        {
            $i = imagecreatefromjpeg($image);
        }
        if ($mimeType == 'image/png')
        {
            $i = imagecreatefrompng($image);
        }
        if ($mimeType == 'image/gif')
        {
            $i = imagecreatefromgif($image);
        }


        $r_total = null;
        $g_total = null;
        $b_total = null;
        $total   = null;
        for ($x=0;$x<imagesx($i);$x++) {

        for ($y=0;$y<imagesy($i);$y++) {

        $rgb = imagecolorat($i,$x,$y);

        $r = ($rgb >> 16) & 0xFF; $g = ($rgb >> 8) & 0xFF; $b = $rgb & 0xFF;


        $r_total += $r;
        $g_total += $g;
        $b_total += $b;
        $total++;

        }
    }

    $r = round($r_total / $total);
    $g = round($g_total / $total);
    $b = round($b_total / $total);
    $rgb = ($array) ? array('r'=> $r, 'g'=> $g, 'b'=> $b) : sprintf($format, $r, $g, $b);

    return $rgb;
    }
}