<?php
declare(strict_types=1);

$file = fopen(__DIR__ . '/measurements.txt', 'r');
if (!$file) {
    die('Could not open file');
}
$length = 8192;
$previous = '';
while (!feof($file)) {
    $buffer = $previous . fread($file, $length);
    $pos = strripos($buffer, "\n");
    $previous = substr($buffer,  $pos);
    $buffer = substr($buffer, 0, $pos);
    explode("\n", $buffer);
}
fclose($file);

