<?php

namespace App\Interface\Console\Handlers;

use App\Interface\Console\Contracts\IOHandler;
use App\Interface\Console\ExitCode;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

class CommandNotFound implements IOHandler
{
    public function handle(Input $input, Output $output): void
    {
        $command = $input->getCommandName();

        if ($command) {
            $output->write("command not found: $command");
        } else {
            $output->write('command not defined');
        }

        $output->setExitCode(ExitCode::Failure);
    }
}
