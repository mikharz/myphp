<?php

namespace App\Interface\Console\Commands;

use App\Interface\Console\Input;
use App\Interface\Console\Output;

class Service extends Command
{
    public function getOptions(): array|int
    {
        return [
            'interval' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    // 'default' => 5,
                    'min_range' => 1,
                    'max_range' => 60,
                ],
            ],
        ];
    }

    public function handle(Input $input, Output $output): void
    {
        $output->write('starting');

        $this->trapSignals(SIGINT, SIGTERM);

        $interval = $input->getOption('interval') ?: 5;

        $output->write("working with interval: $interval");

        while ($this->signal === null) {
            $output->write('do something');

            sleep($interval);
        }

        $output->write('terminating');
    }
}
