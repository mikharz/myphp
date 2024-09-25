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

$foo = new Input(null, ['file.php', 'foo']);

assert($dispatcher->dispatch($foo) instanceof CommandNotFound);

$dispatcher->addCommand(new MockCommand('foo'));

$handler = $dispatcher->dispatch($foo);

assert($handler instanceof CommandFound);
assert($handler->command->getName() === 'foo');

$bar = new Input(null, ['file.php', 'bar']);

assert($dispatcher->dispatch($bar) instanceof CommandNotFound);

$dispatcher->addCommand(new MockCommand('bar'));

$handler = $dispatcher->dispatch($bar);

assert($handler instanceof CommandFound);
assert($handler->command->getName() === 'bar');

$noop = new Input(null, []);

assert($dispatcher->dispatch($noop) instanceof CommandNotFound);

$dispatcher->setDefaultCommand(new MockCommand('default'));

$handler = $dispatcher->dispatch($noop);

assert($handler instanceof CommandFound);
assert($handler->command->getName() === 'default');

$commands = $dispatcher->getCommands();

assert(count($commands) === 3);
