<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/rootway.php';

if($_SESSION['user'] == NULL){
    header(rootway());
    exit();
}

$err = 0;
if(isset($_POST['btn'])){
    if($_POST['name'] != ''){
            $checkUser=$conn->query("select * from `sklad` where `name` = '" . $_POST['name'] . "' limit 1");
		    $checkUser=$checkUser->fetch();
            if(!$checkUser){
                $prepReg=$conn->prepare("insert into `sklad` (`name`, `about`) values (?,?)");
			    $prepReg=$prepReg->execute(array($_POST['name'], str_replace("\r\n", "<br>", $_POST['about'])));
                header(rootway() . "sklad.php");
                exit();

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
            <h1>Новое место хранения</h1>
            <br>
            <form action="" method="post">
                <input value="<?php echo $_POST['name']; ?>" placeholder="Название" class="inp" type="text" name="name"><br>
                <textarea class="inp" placeholder="Описане места хранения" name="about" id="" cols="30" rows="10"><?php echo $_POST['about']; ?></textarea><br>
                <button name="btn" class="btn" type="submit">Добавить место хранения</button>
            </form>
        </div>
   </div>
   <script>
    <?php
            if($err == 1){
                ?>
                alert('Заполните поле "Название"!');
                <?php
            }
            if($err == 2){
                ?>
                alert('Такое название уже существует!');
                <?php
            }
        ?>
   </script>
</body>
</html>