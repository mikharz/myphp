<?php

use App\Interface\Console\Contracts\Command;
use App\Interface\Console\ExitCode;
use App\Interface\Console\Handlers\CommandFound;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

final class MockCommand implements Command
{
    public function __construct(
        protected \Closure $callback
    ) {}

    public function getName(): string
    {
        return '';
    }

    public function getOptions(): array|int
    {
        return [];
    }

    public function getArguments(): array|int
    {
        return [];
    }

    public function handle(Input $input, Output $output): void
    {
        call_user_func($this->callback, $input, $output);
    }
};

$stream = fopen('/dev/null', 'a');

$input = new Input($stream, []);
$output = new Output($stream, $stream);

$handler = new CommandFound(
    new MockCommand(function (Input $input, Output $output) {
        $output->setExitCode(ExitCode::Failure);
    })
);

$handler->handle($input, $output);

assert($output->getExitCode() === ExitCode::Failure);

$handler = new CommandFound(
    new MockCommand(function () {
        throw new Exception();
    })
);

$handler->handle($input, $output);

assert($output->getExitCode() === ExitCode::Invalid);
