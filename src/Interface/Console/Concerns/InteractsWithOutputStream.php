<?php

namespace App\Interface\Console\Concerns;

trait InteractsWithOutputStream
{
    /**
     * @var resource
     */
    protected $stdout;

    /**
     * @var resource
     */
    protected $stderr;

    public function write(string $data, string $endOfLine = PHP_EOL): void
    {
        fwrite($this->stdout, $data . $endOfLine);
    }

    public function writeError(string $data, string $endOfLine = PHP_EOL): void
    {
        fwrite($this->stderr, $data . $endOfLine);
    }
}
