<?php

namespace App\Interface\Console;

class Input
{
    use Concerns\InteractsWithInputStream;

    /**
     * Input stub: php {console.php}
     */
    protected string $scriptName;

    /**
     * Options: php console.php {--option1=value --option2}
     * @var array<string, bool|string>
     */
    protected array $options = [];

    /**
     * Command name: php console.php --options {command}
     */
    protected string $commandName;

    /**
     * Arguments: php console.php --options command {argument1 argument2 .. argument#}
     * @var string[]
     */
    protected array $arguments = [];

    /**
     * @param resource $stdin
     * @param string[] $argv
     */
    public function __construct($stdin, array $argv)
    {
        $this->stdin = $stdin;

        foreach ($argv as $value) {
            if (preg_match('/--?(\w+)(=(.*))?/', $value, $matches)) {
                $this->options[$matches[1]] = $matches[3] ?? true;
            } elseif (!isset($this->scriptName)) {
                $this->scriptName = $value;
            } elseif (!isset($this->commandName)) {
                $this->commandName = $value;
            } else {
                $this->arguments[] = $value;
            }
        }
    }

    public function hasScriptName(): bool
    {
        return isset($this->scriptName);
    }

    public function getScriptName(): ?string
    {
        return $this->scriptName ?? null;
    }

    public function hasOption(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    public function getOption(string $name): bool|string|null
    {
        return $this->options[$name] ?? null;
    }

    public function filterOptions(array|int $options = FILTER_DEFAULT, bool $addEmpty = true): void
    {
        $this->options = filter_var_array($this->options, $options, $addEmpty) ?: [];
    }

    public function hasCommandName(): bool
    {
        return isset($this->commandName);
    }

    public function getCommandName(): ?string
    {
        return $this->commandName ?? null;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function filterArguments(array|int $options = FILTER_DEFAULT, bool $addEmpty = true): void
    {
        $arguments = array_combine(
            array_map(fn ($index) => "key_$index", array_keys($this->arguments)),
            array_values($this->arguments),
        );

        if (is_array($options)) {
            $options = array_combine(
                array_map(fn ($index) => "key_$index", array_keys($options)),
                array_values($options),
            );
        }

        $arguments = filter_var_array($arguments, $options, $addEmpty) ?: [];

        $this->arguments = array_values($arguments);
    }
}
