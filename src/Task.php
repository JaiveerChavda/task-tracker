<?php
namespace App;

use App\Enum\TaskStatusEnum;
class Task
{
    public int $id = 0;

    public string $status = TaskStatusEnum::Todo->value;

    public string $created_at;

    public string $updated_at;

    
    public function __construct(
        public string $description
    )
    {

    }
    
}

?>