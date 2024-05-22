<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/rootway.php';

if($_SESSION['user'] == NULL){
    header(rootway());
    exit();
}

$id = $_GET['id'];
$checkUser=$conn->query("select * from `sklad` where `id` = '" . $id . "' limit 1");
$thissklad=$checkUser->fetch();
if(!$thissklad){
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
                <h1><?php echo $thissklad['name']; ?></h1><br>
                <p><?php echo $thissklad['about']; ?></p><br>
                <a class="red" href="lib/deletesklad.php?id=<?php echo $id; ?>">Удалить место безвозвратно со всеми товарами записанными здесь</a><br><br>

                <form action="" method="get">
                    <input value="<?php echo $_GET['search']; ?>" type="text" name="search" class="inp" placeholder="Поиск">
                    <input value="<?php echo $id; ?>" type="hidden" name="id">
                    <button type="submit" class="btnlogin" name="btn">Поиск</button>
                </form>

                <br><h2>Находятся здесь</h2>
                <div class="innerflexparent">
                <?php
                $counter = 0;
                $page = $_GET['page'];
                if($page == "" || $page < 0){
                    $page = 0;
                }
                    $recv=$conn->query("select * from `good` WHERE `name` like '%" . $_GET['search'] . "%' AND `id` in (SELECT `good_id` FROM `good_sklad` WHERE `sklad_id` = '" . $id . "') order by `name` limit " . ($page * 100) . ", 100");
                    foreach ($recv as $recv){
                        $c=$conn->query("select `colvo` from `good_sklad` where `good_id` = '" . $recv['id'] . "' AND `sklad_id` = '" . $id . "' limit 1");
                        $co=$c->fetch();
                        $counter++;
                        ?>
                        <div class="pers <?php if($counter % 2 == 1) echo 'blacked'; ?>">
                        
                <img src="photo/<?php echo $recv['img']; ?>" alt="">
                <a class="blue" href="thegood.php?id=<?php echo $recv['id']; ?>"><?php echo $recv['name']; ?></a>
                <p class="red"><?php echo $recv['cost']; ?>р</p>
                <form action="lib/colvochange.php" method="post">
                    <input name="good" value="<?php echo $recv['id']; ?>" type="hidden">
                    <input name="sklad" value="<?php echo $id; ?>" type="hidden">
                    <input class="inp" placeholder="кол-во единиц" name="colvo" value="<?php echo $co['colvo']; ?>" type="number">
                    <input class="btnlogin" type="submit" name="btn" value="Сохранить">
                </form>
                
            </div>
                    <?php
                    }
                  ?>
                  <div class="list">
                  <?php
                    if($counter == 0){
                        ?>
                            <h1 class="grey">Товаров не найдено 🥲</h1>
                        <?php
                    }
                    if($page > 0){
                        ?>
                            <a href="thesklad.php?page=<?php echo $page - 1; ?>&search=<?php echo $_GET['search']; ?>&id=<?php echo $id; ?>">Страница <?php echo $page; ?></a>
                        <?php
                    }
                    if($counter == 100){
                        ?>
                            <a href="thesklad.php?page=<?php echo $page + 1; ?>&search=<?php echo $_GET['search']; ?>&id=<?php echo $id; ?>">Страница <?php echo $page + 2; ?></a>
                        <?php
                    }
                ?>
                </div>
                  <br><h2>Добавить новый товар</h2>
                  <div class="innerflexparent">
                <?php
                $counter2 = 0;
                if($page == "" || $page < 0){
                    $page = 0;
                }
                    $recv=$conn->query("select * from `good` WHERE `name` like '%" . $_GET['search'] . "%' AND `id` NOT IN (SELECT `good_id` FROM `good_sklad` WHERE `sklad_id` = '" . $id . "') order by `name` limit " . ($page * 100) . ", 100");
                    foreach ($recv as $recv){
                        $counter2++;
                        $c=$conn->query("select `colvo` from `good_sklad` where `good_id` = '" . $recv['id'] . "' AND `sklad_id` = '" . $id . "' limit 1");
                        $co=$c->fetch();
                        
                        ?>
                        <div class="pers <?php if($counter2 % 2 == 1) echo 'blacked'; ?>">
                        
                <img src="photo/<?php echo $recv['img']; ?>" alt="">
                <a class="blue" href="thegood.php?id=<?php echo $recv['id']; ?>"><?php echo $recv['name']; ?></a>
                <p class="red"><?php echo $recv['cost']; ?>р</p>
                <form action="lib/addsklad.php" method="post">
                    <input name="good" value="<?php echo $recv['id']; ?>" type="hidden">
                    <input name="sklad" value="<?php echo $id; ?>" type="hidden">
                    <input class="inp" placeholder="кол-во единиц" name="colvo" value="<?php echo $co['colvo']; ?>" type="number">
                    <input class="btnlogin" type="submit" name="btn" value="Сохранить">
                </form>
                
            </div>
                    <?php
                    }
                  ?>
                    <div class="list">
                  <?php
                    if($counter2 == 0){
                        ?>
                            <h1 class="grey">Товаров не найдено 🥲</h1>
                        <?php
                    }
                    if($page > 0){
                        ?>
                            <a href="thesklad.php?page=<?php echo $page - 1; ?>&search=<?php echo $_GET['search']; ?>&id=<?php echo $id; ?>">Страница <?php echo $page; ?></a>
                        <?php
                    }
                    if($counter2 == 100){
                        ?>
                            <a href="thesklad.php?page=<?php echo $page + 1; ?>&search=<?php echo $_GET['search']; ?>&id=<?php echo $id; ?>">Страница <?php echo $page + 2; ?></a>
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