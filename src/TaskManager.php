<?php
namespace App;

use Exception;
class TaskManager
{

    public $tasks = [];
    public string $file_path;

    // storage directory
    public string $directory;

    public function __construct(){
        $this->directory = __DIR__ . '/../storage';
        $this->file_path = $this->directory . '/tasks.json';
        $this->tasks = $this->getTasks();
    }
    public function create(string $description)
    {
        $this->createJsonStorageFile();

        $id = count($this->tasks);
        $task = new Task(description:$description);
        $task->id = $id + 1;
        $task->is_completed = false;

        array_push($this->tasks,$task);

        file_put_contents($this->file_path,json_encode($this->tasks,JSON_PRETTY_PRINT));

        return $task;
    }

    public function getTasks()
    {
        $this->createJsonStorageFile();
        
        if(!file_exists($this->file_path)){

            throw new Exception('file not found');
        }

        return json_decode(file_get_contents($this->file_path),true);

    }

    public function createJsonStorageFile()
    {
        if(file_exists($this->file_path)){
            return;
        }

        if(!is_dir($this->directory)){
            mkdir($this->directory,0777,true);
        }

        $initialData = json_encode([],JSON_PRETTY_PRINT);

        if(file_put_contents($this->file_path,$initialData) == false){
            throw new Exception('unable to create tasks.json file');
        };

        return true;        
        
    }
}
?>