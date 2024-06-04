<?php
// The path to the .bat file
$batFilePath = '.\script.bat'; // Use __DIR__ to get the current directory

// Run the .bat file in the background
$command = "start /B cmd /c \"$batFilePath\"";
exec($command, $output, $returnVar);
// exec("cmd /c $batFilePath 2>&1", $output, $returnVar); // Redirect stderr to stdout

// Check if the command was executed successfully
if ($returnVar === 0) {
    echo "The .bat file was executed successfully.\n";
} else {
    echo "There was an error running the .bat file.\n";
}

// Output the result of the .bat file execution
foreach ($output as $line) {
    echo $line . "\n";
}
