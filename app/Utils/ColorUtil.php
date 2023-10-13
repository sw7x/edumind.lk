<?php
namespace App\Utils;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;


class ColorUtil{


    public static function generateBannerColors($imgPath){

        $bgColorCss = static::imgBgGradient($imgPath);

        $mostUsedColors = static::getMostUsed8Colors($imgPath);
        $mostUsedColor  = Color::fromIntToHex(array_keys($mostUsedColors)[0]);

        $contrastColor  = static::getContrastColor($mostUsedColor);
        $invColor       = static::getInvertColor($contrastColor);

        return array(
            'bgColor'     => $bgColorCss,
            'txtColor'    => $contrastColor,
            'invColor'    => $invColor
        );

    }

    
    public static function imgBgGradient($imgPath){

        $topEightColors = static::getMostUsed8Colors($imgPath);

        $color1 = Color::fromIntToHex(array_keys($topEightColors)[0]);
        $color2 = Color::fromIntToHex(array_keys($topEightColors)[1]);
        $color3 = Color::fromIntToHex(array_keys($topEightColors)[3]);
        $color4 = Color::fromIntToHex(array_keys($topEightColors)[4]);
        $color5 = Color::fromIntToHex(array_keys($topEightColors)[5]);
        $color6 = Color::fromIntToHex(array_keys($topEightColors)[6]);
        $color7 = Color::fromIntToHex(array_keys($topEightColors)[7]);


        //$bgColorCss = "background: linear-gradient(to right,{$color1},{$color3},{$color5},{$color4},{$color2})";
        $bgColorCss = "linear-gradient(to right,{$color1},{$color3},{$color2})";
        //$bgColorCss = "background: linear-gradient(to right,{$color1},{$color4},{$color6})";
        //$bgColorCss = "background: linear-gradient(to right,{$color1},{$color3},{$color5})";
        //$bgColorCss = "background: linear-gradient(to right,{$color1},{$color4},{$color2})";

        return $bgColorCss;
    }


    public static function getColorCount($imgPath){
        $palette = Palette::fromFilename($imgPath);
        return count($palette);
    }


    public static function getMostUsed8Colors($imgPath){
        $palette = Palette::fromFilename($imgPath);
        return $palette->getMostUsedColors(8);
    }

    public static function getTop5Colors($imgPath){
        $palette = Palette::fromFilename($imgPath);
        return $palette->getMostUsedColors(5);
    }

    public static function getContrastColor($color1){
        return getContrastColor($color1);
    }


    public static function getInvertColor($color1){
        return hexInvert($color1);
    }


}
