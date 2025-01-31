<?php
namespace App;

use App\Enum\TaskStatusEnum;
class Task
{
    public int $id = 0;

    public string $status = TaskStatusEnum::Todo->value;

    
    public function __construct(
        public string $description
    )
    {

    }
    
}

?>