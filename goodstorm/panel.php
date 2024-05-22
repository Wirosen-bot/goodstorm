<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/rootway.php';

$checkUser=$conn->query("select * from `user` where `id` = '" . $_SESSION['user'] . "' limit 1");
$checkUser=$checkUser->fetch();
if($checkUser['role'] != 1){
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
        <div class="newuser">
                    <a href="reg.php"><h3>Новый пользователь</h3></a>
        </div>
        <main id="anim">
            <?php
            $counter = 0;
                $recv=$conn->query("select * from `user` WHERE `login` like '%" . $_GET['serch'] . "%' order by `login`");
                foreach ($recv as $recv){
                    $counter++;
                    ?>
                        <div class="pers <?php if($counter % 2 == 1) echo 'blacked'; ?>">
                <img src="img/per.png" alt="">
                <p><?php echo $recv['login']; ?></p>
                <form action="lib/userchange.php" method="post">
                    <input name="user" value="<?php echo $recv['id']; ?>" type="hidden">
                    <select class="inplogin" name="role">
                        <option <?php if($recv['role'] == 0) echo 'selected'; ?> value="0">Пользователь</option>
                        <option <?php if($recv['role'] == 1) echo 'selected'; ?> value="1">Администратор</option>
                    </select>
                    <input class="btnlogin" type="submit" name="btn" value="Сохранить">
                </form>
                <a class="red" href="lib/userdel.php?p=<?php echo $recv['id']; ?>">Удалить</a>
            </div>
                    <?php
                }
                if($counter == 0){
                    ?>
                        <h2>Нет результатов :(</h2>
                    <?php
                }
            ?>
            
        </main>
    </div>
    <script src="lib/anime.min.js"></script>
    <script>
anime({
  targets: 'header',
  translateY: [-500, 0],
  easing: 'easeInOutExpo'
});

        anime({
  targets: '#anim',
  translateY: [1500, 0],
  easing: 'easeInOutExpo'
});
</script>
</body>
</html>