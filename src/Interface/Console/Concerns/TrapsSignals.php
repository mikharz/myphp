<?php

namespace App\Interface\Console\Concerns;

trait TrapsSignals
{
    protected ?int $signal = null;

    public function trapSignals(int ...$signals): void
    {
        pcntl_async_signals(true);

        foreach ($signals as $signal) {
            pcntl_signal($signal, function (int $signal) {
                $this->signal = $signal;
            });
        }
    }
}
