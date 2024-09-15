<?php

use App\Interface\Console\ExitCode;
use App\Interface\Console\Handlers\CommandNotFound;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

$stream = fopen('/dev/null', 'a');

$input = new Input($stream, []);
$output = new Output($stream, $stream);

$handler = new CommandNotFound();
$handler->handle($input, $output);

assert($output->getExitCode() === ExitCode::Failure);
