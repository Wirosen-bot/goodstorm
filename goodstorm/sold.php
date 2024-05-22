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
        <hr>
        <main>
            <div class="center">
                <h1>Продажи</h1>
                <a href="newsold.php">Зафиксировать продажу</a>

                <div class="innerflexparent">
                <?php
                $counter = 0;
                $page = $_GET['page'];
                if($page == "" || $page < 0){
                    $page = 0;
                }
                    $recv=$conn->query("select * from `sold` order by `time` DESC limit " . ($page * 100) . ", 100");
                    foreach ($recv as $recv){
                        $counter++;
                        ?>
                        <div class="pers blacked">
                <img src="img/sold.png" alt="">
                <p><?php echo $recv['time']; ?></p>
            </div>
            <hr>
            <?php
                $rec=$conn->query("select * from `sold_good` WHERE `sold_id` = '" . $recv['id'] . "' order by `id`");
                $counter2 = 0;
                foreach ($rec as $rec){
                    $counter2++;
                    $c=$conn->query("select * from `good` WHERE `id` = '" . $rec['good_id'] . "' order by `id` desc limit 1");
                    $c=$c->fetch();
                    if($c){

                    
                        ?>
                        <div class="pers blacked">
                            <p><?php echo $rec['colvo']; ?> ед.</p>
                            <img src="photo/<?php echo $c['img']; ?>" alt="">
                            <a class="blue" href="thegood.php?id=<?php echo $c['id']; ?>"><?php echo $c['name']; ?></a>
                            <p class="red"><?php echo $rec['cost']; ?>р</p>
                        </div>
                    <?php
                    }else{
                        
                    ?>
                    <div class="pers blacked">
                        <p><?php echo $rec['colvo']; ?> ед.</p>
                        <img src="photo/nophoto.png" alt="">
                        <p class="red">Товар был удалён!</p>
                        <p class="red"><?php echo $rec['cost']; ?>р</p>
                    </div>
                <?php
                    }
                }
                if($counter2 == 0){
                    $prepReg=$conn->prepare("delete from `sold` where `id` = ?");
                    $prepReg=$prepReg->execute(array($recv['id']));
                }

            ?>
            <div class="unu"></div>
                    <?php
                    }
                  ?>
                    <div class="list">
                  <?php
                    if($counter == 0){
                        ?>
                            <h1 class="grey">Продаж не найдено 🥲</h1>
                        <?php
                    }
                    if($page > 0){
                        ?>
                            <a href="good.php?page=<?php echo $page - 1; ?>&search=<?php echo $_GET['search']; ?>">Страница <?php echo $page; ?></a>
                        <?php
                    }
                    if($counter == 100){
                        ?>
                            <a href="good.php?page=<?php echo $page + 1; ?>&search=<?php echo $_GET['search']; ?>">Страница <?php echo $page + 2; ?></a>
                        <?php
                    }
                ?>
                </div>
                
            </div>
            </div>
        </main>
    </div>
</body>
</html>