<?php

require_once __DIR__ . '/TaskManager.php';
require_once __DIR__ . '/Enum/TaskStatusEnum.php';

use src\Enum\TaskStatusEnum;
use src\TaskManager;

// remove file name
array_shift($argv);

// show cli error message if no proper task arguments is provided after file name
if (empty($argv)) {
    echo "Usage: php task-tracker.php [add|list|update|delete] [arguments]\n";
    exit();
}

// get the command
$command = $argv[0]; // add/update/delete/list


$taskManager = new TaskManager();

switch ($command) {

    case 'add':

        // check if task name/description is provided ($argv[1] is task description)
        if (isset($argv[1]) && is_string($argv[1])) {
            $description = $argv[1];
            $task = $taskManager->create($description);
            echo "Task created successfully - $task->id \n";
            echo "Total tasks " . count($taskManager->tasks) . "\n";
            exit();
        }

        echo "please add task name!\n";
        echo "for example: php task-tracker.php add 'task name' \n";

        break;

    case 'update':

        // argument task_id not provided
        if (!isset($argv[1])) {
            echo "Please provide task_id like: update 1, update 2. \n";
            exit();
        }

        // argument task_name not provided
        if (!isset($argv[2])) {
            echo " !!! Please provide task name. !!! \n";
            echo "for example: php task-tracker.php update 1 'new task name' \n";
            exit();
        }

        if (isset($argv[2]) && !is_string($argv[2])) {
            echo "Task name is not type of string. \n";
            exit();
        }

        $task_id = $argv[1];

        $task_name = $argv[2];

        $task = $taskManager->updateTask($task_id, $task_name);

        echo $task;
        break;

    case 'list':

        // filter task list by status like: list todo, list completed

        // check status
        if (isset($argv[1])) {
            $status = $argv[1];

            // validate status is a valid task status
            $is_valid_status = in_array($status, array_column(TaskStatusEnum::cases(), 'value'));

            if (!$is_valid_status) {
                echo "!!! Please enter valid status filter. ex: todo|done|in-progress !!! \n";
                die();
            }

            $taskManager->list(title:"show all $status tasks", type: $status);

            // query task using status filter - @TODO

        } else {
            $taskManager->list('show all tasks');
        }

        break;

    case 'delete':

        // argument task_id not provided
        if (!isset($argv[1])) {
            echo "Please provide task_id like: delete 1, delete 2. \n";
            exit();
        }

        echo $taskManager->delete($argv[1]);

        break;

    case 'mark-in-progress':

        // argument task_id not provided
        if (!isset($argv[1])) {
            echo "Please provide task_id like: mark-in-progress 1, mark-in-progress 2. \n";
            exit();
        }

        echo $taskManager->markInProgress($argv[1]);

        break;

    case 'mark-done':

        // argument task_id not provided
        if (!isset($argv[1])) {
            echo "Please provide task_id like: mark-done 1, mark-done 2. \n";
            exit();
        }

        echo $taskManager->markDone($argv[1]);

        break;

    default:
        echo "Invalid command input. see instructions below \n ";
        echo "Usage: php task-tracker.php [add|list|update|delete] [arguments]\n";
        break;
}
