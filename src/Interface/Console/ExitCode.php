<?php

namespace App\Interface\Console;

/**
 * Exit code
 * 
 * @see https://tldp.org/LDP/abs/html/exitcodes.html
 */
enum ExitCode: int
{
    case Success = 0;
    case Failure = 1;
    case Invalid = 2;

    /**
     * @return never
     */
    public function apply(): void
    {
        exit($this->value);
    }
}
