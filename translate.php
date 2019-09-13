<?php 
$jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['original_lang']); // имя файла - это его id
?>
<div class="task-form-wrap task-form-wrap_translate">
    <div class="link-back-wrap">
        <a class="link-back" href="index.php"><img src="./img/cross_icon.png" alt="Close"></a>
    </div>
    
    <form action="index.php?save_translate=<?=$task['id'];?>" method="POST">
        <div class="form-row form-row_translate">
            <?php 
            $jsonFileAccessModel2 = new JsonFileAccessModel('languages');
            $languages = json_decode($jsonFileAccessModel2->read(), true);
            ?>
            <div>
                <?php
                $original_lang = '';
                foreach ($languages as $lang) {
                    if ($lang['id'] == $task['original_lang']) $original_lang = $lang['name'];
                }
                ?>
                <p>Original Language:</p>
                <p><strong><?=$original_lang;?></strong></p>
            </div>

            <div class="form-column_big">
                <?php 
                $translation_lang = '';
                foreach ($task['translation_lang'] as $lang) {
                    foreach ($languages as $value) {
                        if ($value['id'] == $lang) {
                            $translation_lang .= $value['name'];
                            $translation_lang .= "\n";
                        }
                    }
                }
                ?>
                <p>Languages For Translation:</p> 
                <p><strong><?=$translation_lang;?></strong></p>
            </div>

            <div>
                <p>Deadline</p> 
                <p><strong><?=date('d.m.Y', strtotime($task['deadline']));?></strong></p>
            </div>
        </div>

        <textarea class="original-text" readonly><?=$jsonFileAccessModel->read();?></textarea>

        <?php 
        foreach ($task['translation_lang'] as $lang) { 
            $data = '';
            $filename = 'translate_' . $task['id'];
            $jsonFileAccessModel = new JsonFileAccessModel($filename, $lang);
            if ($jsonFileAccessModel->read() != false) $data = $jsonFileAccessModel->read();
            ?>
            <p><strong><?=strtoupper($lang);?></strong></p>
            <textarea name="translation_text_<?=$lang;?>" class="translation-text"><?=$data;?></textarea>
        <?php } ?>

        <div class="form-row">
            <div class="form-column">
                <?php if ($task['status'] == 'new' || $task['status'] == 'rejected') { ?>
                    <a class="task-button task-button_resolve" href="index.php?resolve_translate=<?=$task['id'];?>">Send for Checking</a>
                <?php } elseif ($task['status'] == 'resolved') { ?>
                    <p>Task has Sent for Checking</p>
                <?php } elseif ($task['status'] == 'done') { ?>
                    <p>Task has been done</p>
                <?php } ?>
            </div>
            <div class="form-column">
                <?php if ($task['status'] != 'done') { ?>
                    <input type="submit" value="Save" />
                <?php } ?>
            </div>
        </div>
    </form>
</div>
