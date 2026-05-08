<?php

if (!file_exists('dane.txt')) {
    die("Plik nie istnieje");
}

//fopen('dane.txt', 'w');
//fopen('dane.txt', 'a');
$plik = fopen('dane.txt', 'r');

//echo file_get_contents('dane.txt');


//while (!feof($plik)) {
//    $line = fgets($plik);
//    echo $line;
//}

$linie = file("dane.txt");
print_r($linie);
echo "<br>";
echo count($linie);


fclose($plik);
