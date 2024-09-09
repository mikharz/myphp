<?php

namespace App\Interface\Console\Commands;

use App\Interface\Console\Input;
use App\Interface\Console\Output;

class Greeting extends Command
{
    public function getName(): string
    {
        return 'hello';
    }

    public function getOptions(): array
    {
        return [
            'ucfirst' => FILTER_VALIDATE_BOOL,
        ];
    }

    public function getArguments(): array
    {
        return [ FILTER_DEFAULT ];
    }

    public function handle(Input $input, Output $output): void
    {
        [ $name ] = $input->getArguments();

        while (empty($name)) {
            $output->write('what is you name?');

            $name = $input->read();
        }

        $ucfirst = $input->getOption('ucfirst');

        if ($ucfirst) {
            $name = ucfirst($name);
        }

        $output->write("hello, $name!");
    }
}
