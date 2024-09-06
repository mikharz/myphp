<?php

use App\My;

require __DIR__ . '/../bootstrap.php';

$my = new My();

echo $my->ping() . PHP_EOL;
