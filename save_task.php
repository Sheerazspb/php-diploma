<?php 

foreach ($task as $key => &$task_value) {
    if (isset($_POST[$key]) && $_POST[$key] != $task_value) {
        $task_value = $_POST[$key];
    }
}

if (isset($_POST['text'])) {
    $jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['original_lang']);

    if ($jsonFileAccessModel->read() != $_POST['text']) {
        $jsonFileAccessModel->write($_POST['text']);
        $task['original_text_preview'] = mb_substr($_POST['text'], 0, 420);
    }
}

$replacement = array($task);
$index;
$tasks = $tasksList->getList();

foreach ($tasks as $key => $value) {
    if ($value['id'] == $task['id']) $index = $key;
}

array_splice($tasks, $index, 1, $replacement);
$json_tasks = json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$jsonFileAccessModel2 = new JsonFileAccessModel('tasks');
$jsonFileAccessModel2->write($json_tasks);

header('Location: index.php');