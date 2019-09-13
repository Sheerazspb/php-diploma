<?php 
$jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['original_lang']); // имя файла - это его id
?>
<div class="task-form-wrap task-form-wrap_translate">
    <div class="link-back-wrap">
        <a class="link-back" href="index.php"><img src="./img/cross_icon.png" alt="Close"></a>
    </div>
    
    <form action="index.php?done_task=<?=$task['id'];?>" method="POST">
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
                <p>Translation Language:</p> 
                <p><strong><?=$translation_lang;?></strong></p>
            </div>

            <div>
                <p>Deadline</p> 
                <p><strong><?=$task['deadline']?></strong></p>
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
            <textarea name="translation_text_<?=$lang;?>" class="translation-text" readonly><?=$data;?></textarea>
        <?php } ?>

        <div class="form-row">
            <div class="form-column">
                <label>
                 Current Status: 
                </label>
                <label class="label-status"><input type="radio" name="status" value="done" required />Completed</label>
                <label class="label-status"><input type="radio" name="status" value="rejected" required />Rejected</label>
                <label class="label-status"><input type="radio" name="status" value="" required />Don't Change Status</label>
            </div>
            <div class="form-column">
                <input type="submit" value="Save" />
            </div>
        </div>
    </form>
</div>
