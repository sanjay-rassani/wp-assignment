<?php
session_start();

$category = [
    "study" => ["title" => "study", "icon" => "bi bi-book"],
    "office" => ["title" => "office", "icon" => "bi bi-terminal"],
    "home" => ["title" => "home", "icon" => "bi bi-shop"],
    "friend" => ["title" => "friend", "icon" => " bi bi-person"],
];

$priority = [
    "high" => ["color" => "red", "title" => "high"],
    "medium" => ["color" => "green", "title" => "medium"],
    "low" => ["color" => "yellow", "title" => "low"],
    "stnd" => ["color" => "blue", "title" => "stnd"]
];

if (isset($_POST['show'])) {
    goto LOCA;
}

if (isset($_POST['add-todo'])) {
    $cat = lcfirst($_POST['_cat']);
    $prt = lcfirst($_POST['_prt']);
    $mem = $_POST['_mem'];
    $status = 0;

    $temp = [
        "category" => $category[$cat],
        "priority" => $priority[$prt],
        "memo" => $mem,
        "status" => $status
    ];

    $todo = $_SESSION['todo'];
    array_push($todo, $temp);
    $_SESSION['todo'] = $todo;
}

if (isset($_SESSION['todo'])) {
    $todo = $_SESSION['todo'];
} else {
    LOCA:
    $_SESSION['todo'] = [
        [
            "category" => $category['study'],
            "priority" => $priority['high'],
            "memo" => "Complete the Web Assignment",
            "status" => 1
        ],
        [
            "category" => $category['office'],
            "priority" => $priority['low'],
            "memo" => "Check Out For Evening",
            "status" => 0
        ],
        [
            "category" => $category['office'],
            "priority" => $priority['low'],
            "memo" => "Check Out For Evening",
            "status" => 1
        ],
    ];
    $todo = $_SESSION['todo'];
}

if (isset($_POST['clear-todo'])) {
    $_SESSION['todo'] = array();
}
if (isset($_POST['press-me'])) {
    $key = $_POST['press-me'];
    $todo = $_SESSION['todo'];
    $todo[$key]['status'] = $todo[$key]['status'] == 1 ? 0 : 1;
    $_SESSION['todo'] = $todo;
}

if (isset($_POST['X'])) {
    $index = $_POST['_index'];
    $todo = $_SESSION['todo'];
    unset($todo[$index]);
    $_SESSION['todo'] = $todo;
}

$isOpen = 'Y';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
</head>

<body>
    <?php require_once './header.php' ?>

    <div class="container">

        <div class="row border m-3 p-3">
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Category:</label>
                    <input class="form-control form-control-sm" list="categoryList" id="exampleDataList" name='_cat' placeholder="Type to search..." required>
                    <datalist id="categoryList">
                        <?php foreach ($category as $key => $value) : ?>
                            <option value="<?= ucfirst($value['title']) ?>">
                            <?php endforeach ?>
                    </datalist>
                </div>
                <div class="mb-3">
                    <label class="form-label">Memo:</label>
                    <input class="form-control form-control-sm" type="text" name="_mem" id="" placeholder="Todo Details" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mark:</label>
                    <input class="form-control form-control-sm" list="priorityList" name="_prt" id="exampleDataList" placeholder="Type to search..." required>
                    <datalist id="priorityList">
                        <?php foreach ($priority as $key => $value) : ?>
                            <option value="<?= ucfirst($value['title']) ?>">
                            <?php endforeach ?>
                    </datalist>
                </div>
                <input class="btn btn-sm btn-info" type="submit" name="add-todo" value="Add Todo">
            </form>
        </div>
        <form action="" method="post">
            <input class="btn btn-sm btn-danger" type="submit" name="clear-todo" value="Clear List">
        </form>
        <?php if (sizeof($todo) > 0) : ?>
            <div class="card">
                <div class="card-header">
                    Todo List
                    <div style="float: right; margin-left: 10px ">
                        Delete
                    </div>
                    <div style="float: right; margin-left: 10px ">
                        Complete
                    </div>
                    <div style="float: right; margin-right: 10px ">
                        Priority
                    </div>
                </div>
                <ul class="list-group">
                    <?php foreach ($todo as $key => $instance) : ?>
                        <li class="list-group-item">
                            <div> #<?= $key ?> - <i class="<?= $instance['category']['icon'] ?>"> </i> - <?= $instance['memo'] ?>
                                <div style="float: right; margin-left: 10px ">
                                    <form action="" method="post">
                                        <input type="text" name="_index" value="<?= $key ?>" hidden>
                                        <input type="submit" class="btn btn-danger" value="X" name="X">
                                    </form>
                                </div>
                                <div style="float: right; margin-left: 10px ">
                                    <script>
                                        function fun1() {
                                            document.getElementById('press-me').click();
                                        }
                                    </script>
                                    <form action="" method="post">
                                        <input type="checkbox" onchange="fun1()" name="" style="height: 40px;" id="" <?php if ($instance['status'] == 1) echo ("checked");
                                                                                                                        else echo (""); ?>>
                                        <input type="submit" value="<?= $key ?>" name="press-me" id="press-me" hidden>
                                    </form>
                                </div>
                                <div style="float: right; margin-right: 10px ">
                                    <span style="border-color: <?= $instance['priority']['color'] ?>; color: black; background-color: <?= $instance['priority']['color'] ?>; border-style: solid; border-radius: 50px; padding: 1px 5px;">
                                        <?= ucfirst($instance['priority']['title']) ?>
                                    </span>
                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php else : ?>
            <form action="" method="post">
                <input type="submit" value="Show Sample" name="show">
            </form>
        <?php endif ?>
    </div>


</body>

</html>