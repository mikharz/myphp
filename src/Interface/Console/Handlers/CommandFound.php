<?php

namespace App\Interface\Console\Handlers;

use App\Interface\Console\Contracts\Command;
use App\Interface\Console\Contracts\IOHandler;
use App\Interface\Console\ExitCode;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

class CommandFound implements IOHandler
{
    public function __construct(
        protected Command $command
    ) {}

    public function handle(Input $input, Output $output): void
    {
        $input->filterOptions($this->command->getOptions());
        $input->filterArguments($this->command->getArguments());

        try {
            $this->command->handle($input, $output);
        } catch (\Throwable $exception) {
            $output->writeError((string) $exception);
            $output->setExitCode(ExitCode::Invalid);
        }
    }
}
