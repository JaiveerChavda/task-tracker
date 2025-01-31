<?php

namespace App\Enum;
enum TaskStatusEnum: string
{
    case Done = 'done';
    case Inprogress = 'In-progress';
    case Todo = 'todo';
}
?>