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
$err = 0;
if(isset($_POST['btn'])){
    if($_POST['login'] != '' && $_POST['password'] != '' && $_POST['password2'] != ''){
        if($_POST['password'] == $_POST['password2']){
            $checkUser=$conn->query("select * from `user` where `login` = '" . $_POST['login'] . "' limit 1");
		    $checkUser=$checkUser->fetch();
            if(!$checkUser){
                $prepReg=$conn->prepare("insert into `user` (`login`, `password`) values (?,?)");
			    $prepReg=$prepReg->execute(array($_POST['login'],$_POST['password']));
                header(rootway() . "panel.php");
                exit();

            }else{
                $err = 3;
            }
        }else{
            $err = 2;
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
                <input placeholder="Пароль ещё раз" class="inp" type="password" name="password2"><br>
                <button name="btn" class="btn" type="submit">Добавить пользователя</button>
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
                alert('Пароли не совпадают');
                <?php
            }
            if($err == 3){
                ?>
                alert('Такой пользователь уже существует');
                <?php
            }
        ?>
   </script>
</body>
</html>