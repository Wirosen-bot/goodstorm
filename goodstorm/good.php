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
                <h1>Товары</h1>
                <form action="" method="get">
                    <input value="<?php echo $_GET['search']; ?>" type="text" name="search" class="inp" placeholder="Поиск">
                    <button type="submit" class="btnlogin" name="btn">Поиск</button>
                </form>
                <a href="newgood.php">Новый вид товара</a>

                <div class="innerflexparent">
                <?php
                $counter = 0;
                $page = $_GET['page'];
                if($page == "" || $page < 0){
                    $page = 0;
                }
                    $recv=$conn->query("select * from `good` WHERE `name` like '%" . $_GET['search'] . "%' order by `name` limit " . ($page * 100) . ", 100");
                    foreach ($recv as $recv){
                        ?>
                            <div class="block">
                                <a href="thegood.php?id=<?php echo $recv['id']; ?>">
                                    <img class="icomain" src="photo/<?php echo $recv['img']; ?>" alt="">
                                    <p><?php echo $recv['name']; ?> <span class="red"><?php echo $recv['cost']; ?>р</span> </p>
                                </a>
                            </div>
                        <?php
                        $counter++;
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