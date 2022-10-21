<?php

function color_inverse($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}



function hexInvert(string $color):string {
    $color = trim($color);
    $prependHash = false;
    if (strpos($color, '#') !== false) {
        $prependHash = true;
        $color = str_replace('#', '', $color);
    }
    $len = strlen($color);
    if($len==3 || $len==6){
        if($len==3) $color = preg_replace('/(.)(.)(.)/', "\\1\\1\\2\\2\\3\\3", $color);
    } else {
        throw new \Exception("Invalid hex length ($len). Length must be 3 or 6 characters");
    }
    if (!preg_match('/^[a-f0-9]{6}$/i', $color)) {
        throw new \Exception(sprintf('Invalid hex string #%s', htmlspecialchars($color, ENT_QUOTES)));
    }

    $r = dechex(255 - hexdec(substr($color, 0, 2)));
    $r = (strlen($r) > 1) ? $r : '0' . $r;
    $g = dechex(255 - hexdec(substr($color, 2, 2)));
    $g = (strlen($g) > 1) ? $g : '0' . $g;
    $b = dechex(255 - hexdec(substr($color, 4, 2)));
    $b = (strlen($b) > 1) ? $b : '0' . $b;

    return ($prependHash ? '#' : '') . $r . $g . $b;
}


//Luminosity Contrast algorithm
function getContrastColor($hexColor){

    // hexColor RGB
    $R1 = hexdec(substr($hexColor, 1, 2));
    $G1 = hexdec(substr($hexColor, 3, 2));
    $B1 = hexdec(substr($hexColor, 5, 2));

    // Black RGB
    $blackColor = "#000000";
    $R2BlackColor = hexdec(substr($blackColor, 1, 2));
    $G2BlackColor = hexdec(substr($blackColor, 3, 2));
    $B2BlackColor = hexdec(substr($blackColor, 5, 2));

    // Calc contrast ratio
    $L1 = 0.2126 * pow($R1 / 255, 2.2) +
        0.7152 * pow($G1 / 255, 2.2) +
        0.0722 * pow($B1 / 255, 2.2);

    $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
        0.7152 * pow($G2BlackColor / 255, 2.2) +
        0.0722 * pow($B2BlackColor / 255, 2.2);

    $contrastRatio = 0;
    if ($L1 > $L2) {
        $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
    } else {
        $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
    }

    // If contrast is more than 5, return black color
    if ($contrastRatio > 5) {
        return '#000000';
    } else {
        // if not, return white color.
        return '#FFFFFF';
    }
}
