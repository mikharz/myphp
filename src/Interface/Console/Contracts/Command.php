<?php

namespace App\Interface\Console\Contracts;

interface Command extends IOHandler
{
    public function getName(): string;

    public function getOptions(): array|int;

    public function getArguments(): array|int;

    // public function execute(): bool;
}
