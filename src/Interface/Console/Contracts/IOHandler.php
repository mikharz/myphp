<?php

namespace App\Interface\Console\Contracts;

use App\Interface\Console\Input;
use App\Interface\Console\Output;

interface IOHandler
{
    public function handle(Input $input, Output $output): void;
}
