<?php

require 'vendor/autoload.php';

use App\TaskManager;

// remove file name
array_shift($argv);

// show cli error message if no proper task arguments is provided after file name
if(empty($argv)){
    echo "Usage: php task-tracker.php [add|list|complete] [arguments]\n";
    exit();
}

// get the command
$command = $argv[0]; // add/update/delete

$description = $argv[1];

$taskManager = new TaskManager();

switch ($command) {

    case 'add':

        if (isset($description) && is_string($description)) {
            $task = $taskManager->create($description);
            echo "Task created successfully - $task->id \n";
            echo "Total tasks " . count($taskManager->tasks) . "\n";
            exit();
        }
        echo "please add task name!\n";
        break;

    case 'update':
        var_dump($action);

    default:
        # code...
        break;
}

