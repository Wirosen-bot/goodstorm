<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/rootway.php';

if($_SESSION['user'] == NULL){
    header(rootway());
    exit();
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Good Storm Товарооборот</title>
</head>
<body>
    <div class="screen">
        <header>
            <div class="mar">
                <a href="main.php"><h1>Good Storm</h1></a>
            </div>
            <div class="mar">
                <?php
                    $checkUser=$conn->query("select * from `user` where `id` = '" . $_SESSION['user'] . "' limit 1");
                    $checkUser=$checkUser->fetch();
                    if ($checkUser['role'] == 1){
                        ?>
                            <a class="na" href="panel.php">Панель</a>
                        <?php
                    }
                ?>
                <a href="out.php">Выйти (<?php
                    echo $checkUser['login'];
                ?>)</a>
            </div>
        </header>
        <main>
            <div class="innerflexparent">
                <div class="block">
                    <a href="sklad.php">
                    <img class="icomain" src="img/sklad.png" alt="">
                    <p>Места хранения</p>
                    </a>
                </div>
                <div class="block">
                <a href="good.php">
                    <img class="icomain" src="img/good.png" alt="">
                    <p>Товары</p>
                    </a>
                </div>
                <div class="block">
                <a href="sold.php">
                    <img class="icomain" src="img/sold.png" alt="">
                    <p>Продажи</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>