<?php

use App\Interface\Console\Commands;
use App\Interface\Console\Dispatcher;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

require __DIR__ . '/bootstrap.php';

$input = new Input(STDIN, $argv);
$output = new Output(STDOUT, STDERR);

$dispatcher = new Dispatcher();
$dispatcher->addCommand(new Commands\Greeting());
$dispatcher->setDefaultCommand(
    new Commands\Usage($dispatcher)
);

$handler = $dispatcher->dispatch(
    $input->getCommandName()
);

$handler->handle($input, $output);

$output->getExitCode()->apply();
