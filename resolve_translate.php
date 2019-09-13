<?php

if (isset($task)) {
    $getJson = new JsonFileAccessModel('tasks');
    $tasks = json_decode($getJson->read(), true);
    foreach ($tasks as &$task_value) {
        if ($task_value['id'] == $task['id']) {
            $task_value['status'] = 'resolved';

        }
    }
    
    $json_tasks = json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
   
    $getJson->write($json_tasks);
}



