<?php

namespace App\Interface\Console\Commands;

use App\Interface\Console\Dispatcher;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

class Usage extends Command
{
    public function __construct(
        protected Dispatcher $dispatcher
    ) {}

    public function handle(Input $input, Output $output): void
    {
        $stub = $input->getScriptName();

        $output->write("usage: $stub [options] <command> [arguments]");

        $commands = $this->dispatcher->getCommands();

        if ($commands) {
            $output->write('commands:');

            foreach ($commands as $command) {
                $name = $command->getName();

                $output->write("  $name");
            }
        }
    }
}
