# Just reading of file

## Reading with `fgets`

```php
<?php
declare(strict_types=1);

$file = fopen(__DIR__ . '/measurements.txt', "r");
if (!$file) {
    die('Could not open file');
}
while (!feof($file)) {
    fgets($file);
}
```
Took: 
```shell
php 1brc.php  55,69s user 1,56s system 99% cpu 57,271 total
```


## Parsing values with `fscanf`

```php
// ...

while (!feof($file)) {
    [$a, $b] = fscanf($file, "%[^;];%f\n");
}
```

Took: 
```shell
php 1brc.php  238,01s user 1,34s system 99% cpu 3:59,37 total
```
