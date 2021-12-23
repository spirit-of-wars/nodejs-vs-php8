<?php
//require_once __DIR__ . '/lib/vendor/autoload.php';
//
//$app = new \MIF\App();
//$app->run();


$phpVersion = "v" . explode('-', PHP_VERSION)[0];


$start = microtime(1);
$str = '';
for ($i = 0; $i < 1000000; $i++) {
    $str .= 's';
}

echo "PHP $phpVersion: склеивание строк 1000000 раз: " . round((microtime(1) - $start) * 1000, 3) . "ms \n";


$start = microtime(1);
$count = 0;
for ($i = 0; $i < 1000000; $i++) {
    $count++;
}

echo "PHP $phpVersion: сложение чисел 1000000 раз: " . round((microtime(1) - $start) * 1000, 3) . "ms \n";


$start = microtime(1);
$array = array();
for ($i = 0; $i < 1000000; $i++) {
    $array[] = 's';
}

echo "PHP $phpVersion: наполнение простого массива 1000000 раз: " . round((microtime(1) - $start) * 1000, 3) . "ms \n";


$start = microtime(1);
$array = array();
for ($i = 0; $i < 1000000; $i++) {
    $array["s" . $i] = 's';
}

echo "PHP $phpVersion: наполнение ассоциативного массива 1000000 раз: " . round((microtime(1) - $start) * 1000, 3) . "ms \n";


$start = microtime(1);
for ($i = 0; $i < 100; $i++) {
    $fp = fopen("./someFile.txt", "r");
    $content = fread($fp, filesize("./someFile.txt"));
    fclose($fp);
}

echo "PHP $phpVersion: чтение файла 100 раз: " . round((microtime(1) - $start) * 1000, 3) . "ms \n";


$start = microtime(1);
$mysql = new mysqli('localhost', 'root', 'password', 'mif_ru');
for ($i = 0; $i < 100; $i++) {
    $res = $mysql->query("SELECT NOW() as `now`");
    $now = $res->fetch_assoc()['now'];
}

echo "PHP $phpVersion: mysql query (SELECT NOW()) 100 раз: " . round((microtime(1) - $start) * 1000, 3) . "ms \n";
