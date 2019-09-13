<?php 

class TasksList 
{
    private $tasks;
    private $filter;

    public function __construct($role = null)
    {
        $jsonFileAccessModel = new JsonFileAccessModel('tasks');
        $this->tasks = json_decode($jsonFileAccessModel->read(), true);

        function sortTasks($a, $b) {
            if ($a['deadline'] == $b['deadline']) {
                return 0;
            }
            return ($a['deadline'] < $b['deadline']) ? -1 : 1;
        }

        uasort($this->tasks, 'sortTasks');

        if ($role == 'translator' && count($this->tasks) > 0) {
            $this->tasks = array_filter($this->tasks, function($task) {
                return $task['executor'] == $_SESSION['login'];
            });
        }
    }

    public function getList()
    {
        return $this->tasks;
    }

    public function getFilteredList($filter)
    {
        $this->filter = $filter;
        $filtered_tasks = array_filter($this->tasks, function($task) {
            return $task['status'] == $this->filter;
        });
        return $filtered_tasks;
    }

    public function getTask($id) 
    {
        $found_task = array();
        foreach ($this->tasks as $value) {
            if ($value['id'] == $id) $found_task = $value;
        }

        return $found_task;
    }

    public function getTasksNum($translator_login)
    {
        $counter = 0;
        foreach ($this->tasks as $value) {
            if ($value['executor'] == $translator_login) $counter++;
        }
        return $counter;
    }
}