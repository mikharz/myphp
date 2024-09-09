<?php

namespace App\Interface\Console\Concerns;

trait InteractsWithInputStream
{
    /**
     * @var resource
     */
    protected $stdin;

    public function read(): string
    {
        $data = fgets($this->stdin);

        return $data !== false ? trim($data) : '';
    }
}
