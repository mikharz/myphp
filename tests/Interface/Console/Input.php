<?php

use App\Interface\Console\Input;

$cmdline = 'file.php --foo=bar -f=b --email=invalid --bool string arg1 arg2 arg3';

$input = new Input(null, explode(' ', $cmdline));

assert($input->hasScriptName());
assert($input->getScriptName() === 'file.php');

assert($input->hasOption('foo'));
assert($input->getOption('foo') === 'bar');

assert($input->hasOption('f'));
assert($input->getOption('f') === 'b');

assert($input->hasOption('email'));
assert($input->getOption('email') === 'invalid');

assert($input->hasOption('bool'));
assert($input->getOption('bool') === true);

assert(!$input->hasOption('int'));

$input->filterOptions([
    'foo' => FILTER_DEFAULT,
    'email' => FILTER_VALIDATE_EMAIL,
    'bool' => FILTER_VALIDATE_BOOL,
    'int' => FILTER_VALIDATE_INT,
]);

assert($input->getOption('foo') === 'bar');
assert($input->getOption('email') === false);
assert($input->getOption('bool') === true);
assert($input->hasOption('int'));
assert($input->getOption('int') === null);
assert(!$input->hasOption('f'));

assert($input->hasCommandName());
assert($input->getCommandName() === 'string');
assert(!$input->hasOption('string'));

$args = $input->getArguments();

assert(count($args) === 3);
assert($args[0] === 'arg1' && $args[1] === 'arg2' && $args[2] === 'arg3');

$input->filterArguments([
    FILTER_DEFAULT,
    FILTER_VALIDATE_INT,
    [
        'filter' => FILTER_DEFAULT,
        'flags' => FILTER_FORCE_ARRAY,
    ],
    FILTER_DEFAULT,
]);

$args = $input->getArguments();

assert(count($args) === 4);
assert($args[0] === 'arg1');
assert($args[1] === false);
assert(is_array($args[2]) && $args[2][0] === 'arg3');
assert($args[3] === null);
