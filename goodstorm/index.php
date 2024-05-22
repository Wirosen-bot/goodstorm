<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/rootway.php';

if($_SESSION['user'] != NULL){
    header(rootway() . "main.php");
    exit();
}

$err = 0;
if(isset($_POST['btn'])){
    if($_POST['login'] != '' && $_POST['password'] != ''){
            $checkUser=$conn->query("select * from `user` where `login` = '" . $_POST['login'] . "' limit 1");
		    $checkUser=$checkUser->fetch();
            if($checkUser){
                if($checkUser['password'] == $_POST['password']){
                    $_SESSION['user'] = $checkUser['id'];
                    header(rootway() . "main.php");
                    exit();
                }else{
                    $err = 2;
                }
                

            }else{
                $err = 3;
            }
    }else{
        $err = 1;
    }
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
   <div class="flexparent">
        <div class="loginform">
            <h1>Good Storm</h1>
            <p>Товарооборот</p>
            <br>
            <form action="" method="post">
                <input value="<?php echo $_POST['login']; ?>" placeholder="Логин" class="inp" type="text" name="login"><br>
                <input placeholder="Пароль" class="inp" type="password" name="password"><br>
                <button name="btn" class="btn" type="submit">Войти</button>
            </form>
        </div>
   </div>
   <script>
    <?php
            if($err == 1){
                ?>
                alert('Не все поля заполнены!');
                <?php
            }
            if($err == 2){
                ?>
                alert('Неверный логин или пароль');
                <?php
            }
            if($err == 3){
                ?>
                alert('Неверный логин или пароль');
                <?php
            }
        ?>
   </script>
</body>
</html>