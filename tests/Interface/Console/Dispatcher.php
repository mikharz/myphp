<?php

use App\Interface\Console\Contracts\Command;
use App\Interface\Console\Dispatcher;
use App\Interface\Console\Handlers\CommandFound;
use App\Interface\Console\Handlers\CommandNotFound;
use App\Interface\Console\Input;
use App\Interface\Console\Output;

final class MockCommand implements Command
{
    public function __construct(
        public readonly string $name
    ) {}

    public function getName(): string
    {
        return $this->name;
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
        throw new Exception('handle');
    }
}

$dispatcher = new Dispatcher();

$commands = $dispatcher->getCommands();

assert(count($commands) === 0);

assert($dispatcher->dispatch('foo') instanceof CommandNotFound);

$dispatcher->addCommand(new MockCommand('foo'));

$handler = $dispatcher->dispatch('foo');

assert($handler instanceof CommandFound);
assert($handler->command->getName() === 'foo');

assert($dispatcher->dispatch('bar') instanceof CommandNotFound);

$dispatcher->addCommand(new MockCommand('bar'));

$handler = $dispatcher->dispatch('bar');

assert($handler instanceof CommandFound);
assert($handler->command->getName() === 'bar');

assert($dispatcher->dispatch() instanceof CommandNotFound);

$dispatcher->setDefaultCommand(new MockCommand('default'));

$handler = $dispatcher->dispatch();

assert($handler instanceof CommandFound);
assert($handler->command->getName() === 'default');

$commands = $dispatcher->getCommands();

assert(count($commands) === 3);
