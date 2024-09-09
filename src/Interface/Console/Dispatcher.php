<?php

namespace App\Interface\Console;

class Dispatcher
{
    /**
     * @var array<string, Contracts\Command>
     */
    protected array $commands = [];

    protected string $defaultCommandName;

    /**
     * @return Contracts\Command[]
     */
    public function getCommands(): array
    {
        return array_values($this->commands);
    }

    public function getCommand(string $commandName): ?Contracts\Command
    {
        return $this->commands[$commandName] ?? null;
    }

    public function addCommand(Contracts\Command $command): void
    {
        $this->commands[$command->getName()] = $command;
    }

    public function getDefaultCommand(): ?Contracts\Command
    {
        return isset($this->defaultCommandName) ? $this->commands[$this->defaultCommandName] : null;
    }

    public function setDefaultCommand(Contracts\Command $command): void
    {
        $this->addCommand($command);

        $this->defaultCommandName = $command->getName();
    }

    /**
     * @return Contracts\IOHandler
     */
    public function dispatch(?string $commandName = null): Contracts\IOHandler
    {
        $command = $commandName === null ? $this->getDefaultCommand() : $this->getCommand($commandName);

        if ($command === null) {
            return new Handlers\CommandNotFound();
        }

        return new Handlers\CommandFound($command);
    }
}
