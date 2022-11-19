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
    $start_pos = strpos($rgb, '(');
    $end_pos   = strpos($rgb, ')');
    $string    = substr($rgb,$start_pos, $end_pos);
    $trim      = trim($string, '()');
    $color     = explode(',', $trim);
    $colorRgb  = preg_replace('/\s+/', '', $color);
    $this->rgbToHex($colorRgb[0], $colorRgb[1], $colorRgb[2]);
    }

    protected function rgbToHex($r, $g, $b)
    {

    if (is_array($r) && sizeof($r) == 3)
    {
        list($r, $g, $b) = $r;
    }
        $r = intval($r); 
        $g = intval($g);
        $b = intval($b);
        $r = dechex($r<0?0:($r>255?255:$r));
        $g = dechex($g<0?0:($g>255?255:$g));
        $b = dechex($b<0?0:($b>255?255:$b));
        $color = (strlen($r) < 2?'0':'').$r;
        $color .= (strlen($g) < 2?'0':'').$g;
        $color .= (strlen($b) < 2?'0':'').$b;
        $color ='#'.$color;
        return $color;
    }
}
