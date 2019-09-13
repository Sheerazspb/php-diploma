<?php 

if (isset($_POST) && count($_POST) > 0) {
    foreach ($_POST as $key => $value) {
        $lang_id = substr($key, -2);
        $filename = 'translate_' . $task['id'];
        $jsonFileAccessModel = new JsonFileAccessModel($filename, $lang_id);
        $jsonFileAccessModel->write($value);
    }
}

header('Location: index.php');