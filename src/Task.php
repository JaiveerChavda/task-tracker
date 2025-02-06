<?php

namespace src;

require_once __DIR__ . '/Enum/TaskStatusEnum.php';

use src\Enum\TaskStatusEnum;

class Task
{
    public int $id = 0;

    public string $status = TaskStatusEnum::Todo->value;

    public string $created_at;

    public string $updated_at;


    public function __construct(
        public string $description
    ) {

    }

}
