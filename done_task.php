<?php 

if (isset($task) && isset($_POST['status'])) {

    $tasks = $tasksList->getList();

    if ($_POST['status'] != '') {
        foreach ($tasks as &$task_value) {
            if ($task_value['id'] == $task['id']) {
                $task_value['status'] = $_POST['status'];
            }
        }

        $json_tasks = json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $jsonFileAccessModel = new JsonFileAccessModel('tasks');
        $jsonFileAccessModel->write($json_tasks);
    }
}