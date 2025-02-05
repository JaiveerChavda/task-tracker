<?php
namespace src;

require_once __DIR__ . '/Enum/TaskStatusEnum.php';
require_once __DIR__ . '/Task.php';

use src\Enum\TaskStatusEnum;
use src\Task;

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
        $task->created_at = date('d-m-Y H:i:s');
        $task->updated_at = date('d-m-Y H:i:s');

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
        $noMoreTask = false;

        // filter tasks by given type
        if(!is_null($type)){
            $this->tasks = array_filter($this->tasks, function ($task) use ($type) {
                if($task['status'] === $type){
                    return $task;
                }
            });
        }

        $noMoreTask = count($this->tasks) <= 0 ? true : false;

        echo "$title \n";
        echo "+------+-------------------------------------------+-----------------------+-----------------------+-----------------+ \n";
        echo "| ID   | Description                               | Created at            | Updated at            | Status          |\n";
        echo "+------+-------------------------------------------+-----------------------+-----------------------+-----------------+ \n";
        
        if($noMoreTask){
            printf("| %-100s               |\n","No more tasks to show");
        }else{
            foreach ($this->tasks as  $task) {
                printf("| %-4d | %-41s | %-21s | %-21s | %-15s |\n", $task['id'], $task['description'], $task['created_at'], $task['updated_at'] ?? "-", $task['status']);
            };
        }
    
        echo "+------+-------------------------------------------+-----------------------+-----------------------+-----------------+ \n";
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
                $item['updated_at'] = date('d-m-Y H:i:s');
                $task = $item;
            }

            array_push($updatedTasks,$item);

        }

        $this->tasks = $updatedTasks;

        file_put_contents($this->file_path,json_encode($this->tasks,JSON_PRETTY_PRINT));
        
        return "Task updated successfully \n" ;
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

    /**
     * @param int $id
     * delete a task
     * @return string $response;
     */

    public function delete(int $id): string
    {
        $id -= 1;

        if(!array_key_exists($id,$this->tasks)){
            return "!!! task does not exists (invalid task_id) !!! \n";
        }

        foreach($this->tasks as $key => $task){
            if($key === $id){
                unset($this->tasks[$key]);
            }
        }

        $this->tasks = array_values($this->tasks);

        // update tasks.json file to reflect changes
        file_put_contents($this->file_path,json_encode($this->tasks,JSON_PRETTY_PRINT));

        return "Task Deleted Successfully \n";
    }
}
?>