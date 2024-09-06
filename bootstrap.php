<?php

define('MY_NAMESPACE', 'App\\');
define('MY_SOURCE_PATH', __DIR__ . '/src/');
define('MY_SOURCE_EXTENSION', '.php');

spl_autoload_register(function ($className) {
    if (str_starts_with($className, MY_NAMESPACE)) {
        $relativeClassName = substr($className, strlen(MY_NAMESPACE));
        $sourceFileName = MY_SOURCE_PATH . str_replace('\\', '/', $relativeClassName) . MY_SOURCE_EXTENSION;

        if (file_exists($sourceFileName)) {
            require $sourceFileName;
        }
    }
});
