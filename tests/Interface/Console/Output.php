<?php

use App\Interface\Console\Output;

$output = new Output(null, null);

$output->exitSuccess();

assert($output->getExitCode()->value === 0);

$output->exitFailure();

assert($output->getExitCode()->value === 1);

$output->exitInvalid();

assert($output->getExitCode()->value === 2);
