<?php

define('MY_TESTS_PATH', __DIR__ . '/tests/');

require __DIR__ . '/bootstrap.php';

function tests($argc, $argv): Traversable
{
    if ($argc > 1) {
        for ($i = 1; $i < $argc; $i++) {
            $filename = MY_TESTS_PATH . $argv[$i] . '.php';
            yield $filename => [ $filename ];
        }
    } else {
        yield from new RegexIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(MY_TESTS_PATH)
            ),
            '/^.+\.php$/i',
            RegexIterator::GET_MATCH,
        );
    }
}

function execute(string $filename): void
{
    include $filename;
}

$assertions = ini_get('zend.assertions');

echo 'https://www.php.net/manual/en/ini.core.php#ini.zend.assertions' . PHP_EOL;
echo "zend.assertions = $assertions" . PHP_EOL,
    PHP_EOL;

$number = 0;
$success = 0;
$failure = 0;

foreach (tests($argc, $argv) as [ $filename ]) {
    $number++;
    $name = substr($filename, strlen(MY_TESTS_PATH), -4);

    echo "$number. $name ... ";

    if (!is_file($filename)) {
        echo 'not found' . PHP_EOL;
        $failure++;
        continue;
    }

    $pid = pcntl_fork();

    if (!~$pid) {
        throw new Exception('Fork failed');
    }

    if ($pid === 0) {
        try {
            execute($filename);
            echo 'ok' . PHP_EOL;
            exit(0);
        } catch (AssertionError $assertionError) {
            $message = $assertionError->getMessage();
            if (str_starts_with($message, 'assert(')) {
                $message = substr($message, 7, -1);
            }
            $line = $assertionError->getLine();
            echo "fail: $message (line $line)" . PHP_EOL;
            exit(1);
        } catch (Throwable $exception) {
            $name = (new ReflectionClass($exception))->getShortName();
            $message = $exception->getMessage();
            $line = $exception->getLine();
            echo "$name: $message (line $line)" . PHP_EOL;
            exit(1);
        }
    } else {
        pcntl_waitpid($pid, $status);

        if ($status === 0) {
            $success++;
        } else {
            $failure++;
        }
    }
}

echo PHP_EOL,
    "Tests: {$number}. Success: {$success}. Failure: {$failure}." . PHP_EOL;

exit($failure ? 1 : 0);
