<?php

namespace App\Interface\Console\Commands;

use App\Interface\Console\Contracts\Command as CommandInterface;

abstract class Command implements CommandInterface
{
    public function getName(): string
    {
        $reflection = new \ReflectionClass($this);

        return strtolower($reflection->getShortName());
    }

    public function getOptions(): array|int
    {
        return FILTER_DEFAULT;
    }

    public function getArguments(): array|int
    {
        return FILTER_DEFAULT;
    }
}
