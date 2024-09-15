<?php

use App\My;

$my = new My();

assert($my->ping() === 'pong');
