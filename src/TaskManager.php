<?php
namespace App;

use Exception;
class TaskManager
{

    public $tasks = [];
    public string $file_path;

    public function __construct(){
        $this->file_path = __DIR__ . '/../storage/tasks.json';
        $this->tasks = $this->getTasks();
    }
    public function create(string $description)
    {
        $id = count($this->tasks);
        $task = new Task(description:$description);
        $task->id = $id + 1;
        $task->is_completed = false;

        array_push($this->tasks,$task);

        file_put_contents($this->file_path,json_encode($this->tasks));

        return $task;
    }

    public function getTasks()
    {
        
        if(!file_exists($this->file_path)){
            throw new Exception('file not found');
        }

        return json_decode(file_get_contents($this->file_path),true);

    }
}
?>