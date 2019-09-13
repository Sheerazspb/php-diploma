<?php 
$jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['original_lang']); // имя файла - это его id
$filter_param = isset($_GET['filter']) ? "?filter=" . $_GET['filter'] : "";
?>
<div class="task-form-wrap">
    <div class="link-back-wrap">
        <a class="link-back" href="index.php<?=$filter_param;?>"><img src="./img/cross_icon.png" alt="Close"></a>
    </div>
    
    <form action="index.php?save=<?=$task['id'];?>" method="POST">
        <div class="form-row">
            <?php 
            $jsonFileAccessModel2 = new JsonFileAccessModel('users');
            $users = json_decode($jsonFileAccessModel2->read(), true);
            $translators = array_filter($users, function($user) {
                return $user['role'] == 'translator';
            });
            ?>
            <label>
                To: 
                <select name="executor">
                    <option value="">Select</option>
                    <?php 
                    foreach ($translators as $translator) {
                        $tasks_num = $tasksList->getTasksNum($translator['login']);
                        $selected = ($task['executor'] == $translator['login']) ? 'selected' : '';
                        echo '<option value="' . $translator['login'] . '"' . $selected . '>' . $translator['name'] . ' (' . $tasks_num . ')' . '</option>';
                    }
                    ?>
                </select>
            </label>
            <label>
                Client: 
                <input type="text" name="client" value="<?=$task['client'];?>">
            </label>
        </div>

        <div class="form-row">
            <?php 
            $jsonFileAccessModel3 = new JsonFileAccessModel('languages');
            $languages = json_decode($jsonFileAccessModel3->read(), true);
            ?>
            <label>
                Original Language:
                <?php 
                foreach ($languages as $value) {
                    $attr = ($task['original_lang'] == $value['id']) ? 'checked' : 'disabled';
                    echo '<label class="label-lang"><input type="radio" name="original_lang" value="' . $value['id'] . '" ' . $attr . ' />' . $value['name'] . '</label>';
                }
                ?>
            </label>
        </div>

        <div class="form-row">
            <label>
                Languages for Translation:
                <?php 
                foreach ($languages as $key => $value) {
                    $checked = in_array($value['id'], $task['translation_lang']);
                    $checked = $checked ? 'checked' : '';
                    echo '<label class="label-lang"><input type="checkbox" name="translation_lang[' . $key . ']" value="' . $value['id'] . '" ' . $checked . ' />' . $value['name'] . '</label>';
                }
                ?>
            </label>
        </div>
        <textarea name="text" id="" class="original-text"><?=$jsonFileAccessModel->read();?></textarea>

        <div class="form-row">
            <div class="form-column">
                <label>
                    Task Status: 
                </label>
                <?php $checked = ($task['status'] == 'done') ? 'checked' : ''; ?>
                <label class="label-status"><input type="radio" name="status" value="done" <?=$checked?> />Completed</label>
                <?php $checked = ($task['status'] == 'rejected') ? 'checked' : ''; ?>
                <label class="label-status"><input type="radio" name="status" value="rejected" <?=$checked?> />Rejected</label>
            </div>
            <div class="form-column">
                <label>
                    Deadline
                    <input type="date" name="deadline" value="<?=$task['deadline']?>">
                </label>
                <input class="save-button" type="submit" value="Save" />
            </div>
        </div>
    </form>
</div>
