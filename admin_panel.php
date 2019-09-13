<?php 

if (isset($_SESSION['login']) || isset($_COOKIE['login'])) { 
    $tasksList = new TasksList($user->role); 
    $filter_param = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : ""; ?>

    <header class="header header-inner">
        <div class="header-img">
        <h1><?=Config::TITLE ?></h1>
         <img src="./img/globe.gif" alt="globe" class="globe-img">
        </div>
        <a class="logout-button" href="logout.php">Logout</a>
    </header>
    
    <div class="sidebar">
        <div class="photo-wrap">
            <img src="./img/user.gif" alt="photo">
        </div>
        <p class="user-name"><?=$user->name;?></p>
        <p class="user-role"><?=$user->role;?></p>
        <div class="filter">
            <h3 class="filter-title">Tasks</h3>
            <ul class="filter-items">
                <li class="<?=(preg_match('/\/$/', $_SERVER['REQUEST_URI']) == 1 || preg_match('/\/index\.php$/', $_SERVER['REQUEST_URI']) == 1) ? 'filter-item filter-item_active' : 'filter-item' ?>">  
                    <a href="index.php">All</a>
                </li>
                <li class="<?=(preg_match('/filter=new/', $_SERVER['REQUEST_URI']) == 1) ? 'filter-item filter-item_active' : 'filter-item' ?>">
                    <a href="index.php?filter=new">New</a>
                </li>
                <li class="<?=(preg_match('/filter=resolved/', $_SERVER['REQUEST_URI']) == 1) ? 'filter-item filter-item_active' : 'filter-item' ?>">
                    <a href="index.php?filter=resolved">Proccesing</a>
                </li>
                <li class="<?=(preg_match('/filter=rejected/', $_SERVER['REQUEST_URI']) == 1) ? 'filter-item filter-item_active' : 'filter-item' ?>">
                    <a href="index.php?filter=rejected">Rejected</a>
                </li>
                <li class="<?=(preg_match('/filter=done/', $_SERVER['REQUEST_URI']) == 1) ? 'filter-item filter-item_active' : 'filter-item' ?>">
                    <a href="index.php?filter=done">Completed</a>
                </li>
            </ul>
        </div>
        <?php if ($user->role == 'manager') { ?>
            <a class="create-task-button" href="index.php?new=true<?=$filter_param;?>">Create New</a>
        <?php } ?>
    </div>

    <div class="content">
        <?php
        if (isset($_GET['new'])) {
            include 'empty_form.php';
        } elseif (isset($_GET['create'])) {
            include 'create_task.php';
        } elseif (isset($_GET['edit'])) {
            $task = $tasksList->getTask($_GET['edit']);
            include 'task.php';
        } elseif (isset($_GET['save'])) {
            $task = $tasksList->getTask($_GET['save']);
            include 'save_task.php';
        } elseif (isset($_GET['translate'])) {
            $task = $tasksList->getTask($_GET['translate']);
            include 'translate.php';
        } elseif (isset($_GET['save_translate'])) {
            $task = $tasksList->getTask($_GET['save_translate']);
            include 'save_translate.php';
        } elseif (isset($_GET['resolve_translate'])) {
            $task = $tasksList->getTask($_GET['resolve_translate']);
            include 'resolve_translate.php';
        } elseif (isset($_GET['check'])) {
            $task = $tasksList->getTask($_GET['check']);
            include 'check_task.php';
        } elseif (isset($_GET['done_task'])) {
            $task = $tasksList->getTask($_GET['done_task']);
            include 'done_task.php';
        } elseif (isset($_GET['delete'])) {
            $task = $tasksList->getTask($_GET['delete']);
            include 'delete_task.php';
        } else {
            $tasks = $tasksList->getList();
            if (isset($_GET['filter'])) $tasks = $tasksList->getFilteredList($_GET['filter']);
            if (count($tasks) == 0) echo '<p class="info-message">Task not found</p>';

            foreach ($tasks as $value) { ?>
                <?php if ($user->role == 'translator') echo '<a class="task-wrap-link" href="index.php?translate=' . $value['id'] . '">'; ?>
                <div class="task-wrap">
                    <div class="task-header">
                        <div class="task-deadline"><strong><?=date('d.m.Y', strtotime($value['deadline']));?></strong></div>
                        <div class="task-languages">
                            <?php 
                            foreach ($value['translation_lang'] as $lang) {
                                echo "<strong>" . strtoupper($lang) . "</strong>" . "\n";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="task-text-preview"><?=$value['original_text_preview']?>...</div>
                    <div class="task-footer">
                        <?php if ($user->role == 'manager') { ?>
                        <div class="task-buttons">
                            <?php if ($value['status'] == 'resolved') echo '<a class="task-button" href="index.php?check=' . $value['id'] . '">Check</a>'; ?>
                            <a class="task-button task-button_edit" href="index.php?edit=<?=$value['id']?><?=$filter_param;?>">Edit</a>
                            <a class="task-button task-button_delete" href="index.php?delete=<?=$value['id']?><?=$filter_param;?>">Delete</a>
                        </div>
                        <?php } ?>
                        <div class="task-status">Status: <strong><?=$value['status'];?></strong></div>
                    </div>
                </div>
                <?php if ($user->role == 'translator') echo '</a>'; ?>
            <?php } 
        } ?>
    </div>
<?php
}
?>