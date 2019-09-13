<?php 
$filter_param = isset($_GET['filter']) ? "?filter=" . $_GET['filter'] : "";
$jsonFileAccessModel = new JsonFileAccessModel('tasks');
$tasks = json_decode($jsonFileAccessModel->read(), true);
$needed_key;

foreach ($tasks as $key => $value) {
    if ($value['id'] == $task['id']) $needed_key = $key;
}

/* Удаление задания из массива заданий и перезапись файла tasks.json */
unset($tasks[$needed_key]);
$tasks = array_values($tasks);
$json_tasks = json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$jsonFileAccessModel->write($json_tasks);

/* Удаление файла с оригиналом текста */
$filename = Config::FILES_PATH . $task['original_lang'] . '/' . $task['original_text'];

if (file_exists($filename)) {
    unlink($filename);
}

/* Удаление файлов с переводами */
foreach ($task['translation_lang'] as $value) {
    $filename = Config::FILES_PATH . $value . '/translate_' . $task['id'] . '.json';

    if (file_exists($filename)) {
        unlink($filename);
    }
}

header('Location: index.php' . $filter_param); 
