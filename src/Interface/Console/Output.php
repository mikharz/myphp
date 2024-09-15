<?php

namespace App\Interface\Console;

class Output
{
    use Concerns\InteractsWithOutputStream;

    /**
     * @param resource $stdout
     * @param resource $stderr
     */
    public function __construct($stdout, $stderr, protected ExitCode $exitCode = ExitCode::Success)
    {
        $this->stdout = $stdout;
        $this->stderr = $stderr;
    }

    public function exitSuccess(): void
    {
        $this->setExitCode(ExitCode::Success);
    }

    public function exitFailure(): void
    {
        $this->setExitCode(ExitCode::Failure);
    }

    public function exitInvalid(): void
    {
        $this->setExitCode(ExitCode::Invalid);
    }

    public function setExitCode(ExitCode $exitCode): void
    {
        $this->exitCode = $exitCode;
    }

    public function getExitCode(): ExitCode
    {
        return $this->exitCode;
    }
}
