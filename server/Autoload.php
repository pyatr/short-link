<?php

spl_autoload_register(function ($className) {
    $namespaces = [
        'Server',
    ];
    $directories = [
        'Controllers',
        'Models',
        'QueryBuilders',
        'Server'
    ];

    $projectDir = __DIR__ . '\\';
    foreach ($namespaces as $namespace) {
        $prefix = "$namespace\\";
        $prefixLength = strlen($prefix);
        $cleanClassName = substr($className, $prefixLength);
        foreach ($directories as $classDirectory) {
            $file = $projectDir . $classDirectory . '\\' . $cleanClassName . '.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
            if (file_exists($file)) {
                include_once $file;
            }
        }
    }
});