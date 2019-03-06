<?php

function test($poi, $point, $mac, $time) {
    $size = 45;
    $font = "./SIMKAI.TTF";

    $p1 = "POI：{$poi}";
    $p2 = $point;
    $mac = "MAC：{$mac}";
    $date = "DATE：" . date('Y/m/d');

    $img = imagecreatefromjpeg("./hxms.jpg");// 加载已有图像

    $black = imagecolorallocate($img, 213, 26, 33);

    $h = 100;
    $d = 80;
    imagettftext($img, $size, 0, 10, $h, $black, $font, $p1);
    imagettftext($img, $size, 0, 10, $h + $d, $black, $font, $p2);
    imagettftext($img, $size, 0, 10, $h + 2 * $d, $black, $font, $mac);
    imagettftext($img, $size, 0, 10, $h + 3 * $d, $black, $font, $date);

    $name = base64_encode($poi . $point . $mac) . '?t=' . $time;

    $name = str_replace("/", 'x', $name);

    imagejpeg($img, "./shot-screen/{$name}.jpg");
    imagedestroy($img);
}

$time = strtotime('2019-03-05') + 7 * 3600;


$file = fopen('./zj-20190306.csv', 'r');
$res = fgetcsv($file);


while(! feof($file))
{
    $item = fgetcsv($file);
    $o = $time + rand(1, 3600);
    test("{$item[4]}/$item[6]", $item[7], $item[1], $o);
    echo $item[1] . date('Y-m-d H:i:s', $o) . "\n";
}

fclose($file);
