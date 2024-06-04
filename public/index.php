<?php

use Illuminate\Http\Request;

// require __DIR__ . '/init.php';

$descriptorspec = [
    0 => ['pipe', 'r'], // stdin
    1 => ['pipe', 'w'], // stdout
    2 => ['pipe', 'w']  // stderr
];

$process = proc_open('start /B php init.php', $descriptorspec, $pipes);

if (is_resource($process)) {
    fclose($pipes[0]); // Close stdin
    fclose($pipes[1]); // Close stdout
    fclose($pipes[2]); // Close stderr

    define('LARAVEL_START', microtime(true));

    // Determine if the application is in maintenance mode...
    if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
        require $maintenance;
    }

    // Register the Composer autoloader...
    require __DIR__ . '/../vendor/autoload.php';

    // Bootstrap Laravel and handle the request...
    (require_once __DIR__ . '/../bootstrap/app.php')
        ->handleRequest(Request::capture());

    // Close the process handle
    proc_close($process);
} else {
    echo "Failed to start the background process\n";
}
