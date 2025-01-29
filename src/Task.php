<?php
namespace App;
class Task
{
    public int $id = 0;

    public bool $is_completed = false;
    
    public function __construct(
        public string $description
    )
    {

    }
    
}

?>