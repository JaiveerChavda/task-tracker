<?php

namespace App\Enum;
enum TaskStatusEnum: string
{
    case Done = 'done';
    case Inprogress = 'in-progress';
    case Todo = 'todo';
}
?>