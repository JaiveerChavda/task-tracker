<?php
namespace App;

use App\Enum\TaskStatusEnum;
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
        $task->status = TaskStatusEnum::Todo->value;

        array_push($this->tasks,$task);

        file_put_contents($this->file_path,json_encode($this->tasks,JSON_PRETTY_PRINT));

        return $task;
    }

    /**
     * Get all the tasks
     * 
     * return array
     */

    public function list(string $title,string $type = null)
    {
        echo "$title \n";
        echo "+------+---------------------------+-----------------+ \n";
        echo "| ID   | Description               | Status          |\n";
        echo "+------+---------------------------+-----------------+ \n";
        foreach ($this->tasks as  $task) {
            printf("| %-4d | %-25s | %-15s |\n", $task['id'], $task['description'], $task['status'] );
        }

        echo "+------+---------------------------+-----------------+ \n";
    }

    public function updateTask(int $task_id,string $task_name)
    {
        $updatedTasks = [];
        // find the task.
        $task = null;
        foreach($this->tasks as $item){
            if($item['id'] === $task_id){
                $task = $item;
            }
        }

        // if task doesn't exists return error
        if(is_null($task)){
            return "!!! task does not exists (invalid task_id) !!! \n";
        }

        // update the task
        foreach($this->tasks as $item){
            if($item['id'] === $task_id){
                $item['description'] = $task_name;
                $task = $item;
            }

            array_push($updatedTasks,$item);

        }

        $this->tasks = $updatedTasks;

        file_put_contents($this->file_path,json_encode($this->tasks,JSON_PRETTY_PRINT));
        
        return "Task with updated successfully" ;
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