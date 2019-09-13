<?php 

if (isset($_POST['client'])) {
    $jsonFileAccessModel = new JsonFileAccessModel('tasks');

    $tasks = json_decode($jsonFileAccessModel->read(), true);

    $id_list = array();

    foreach ($tasks as $value) {
        if (array_key_exists('id', $value)) $id_list[] = $value['id'];
    }

    $next_id = max($id_list) + 1;
    $translation_lang = array();
    $original_text_preview = mb_substr($_POST['text'], 0, 420);

    if (isset($_POST['translation_lang'])) {
        $translation_lang = $_POST['translation_lang'];
    }

    $new_task = array(
        'id' => $next_id,
        'status' => 'new',
        'client' => $_POST['client'],
        'executor' => $_POST['executor'],
        'original_lang' => $_POST['original_lang'],
        'translation_lang' => $translation_lang,
        'deadline' => $_POST['deadline'],
        'original_text_preview' => $original_text_preview,
        'original_text' => $next_id . '.json'
    );

    $tasks[] = $new_task;
    $json_tasks = json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $jsonFileAccessModel->write($json_tasks);

    $jsonFileAccessModel2 = new JsonFileAccessModel($next_id, $_POST['original_lang']);
    $jsonFileAccessModel2->write($_POST['text']);

    header('Location: index.php');  
}
