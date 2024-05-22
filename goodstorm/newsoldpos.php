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
    if($_POST['colvo'] != '' && $_POST['sklad'] != '' && $_POST['good'] != ''){
        $checkUser=$conn->query("select * from `good_sklad` where `sklad_id` = '" . $_POST['sklad'] . "' AND `good_id` = '" . $_POST['good'] . "' AND `colvo` >= '" . $_POST['colvo'] . "' limit 1");
		    $checkUser=$checkUser->fetch();
            if($checkUser && $_POST['colvo'] > 0){
                $realcolvo = $checkUser['colvo'] - $_POST['colvo'];
                $c=$conn->query("select * from `good` WHERE `id` = '" . $_POST['good'] . "'");
                $c=$c->fetch();
                $realcost = $c['cost'] * $_POST['colvo'];
                $co=$conn->query("select * from `sold` ORDER BY `id` DESC limit 1");
                $co=$co->fetch();
                $prepReg=$conn->prepare("insert into `sold_good` (`cost`, `good_id`, `colvo`, `sold_id`) values (?,?,?,?)");
                $prepReg=$prepReg->execute(array($realcost, $_POST['good'], $_POST['colvo'], $co['id']));
                $prepReg=$conn->prepare("update `good_sklad` set `colvo` = ? where `sklad_id` = '" . $_POST['sklad'] . "' AND `good_id` = '" . $_POST['good'] . "'");
                $prepReg=$prepReg->execute(array($realcolvo));
                $err = 3;
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
            <h1>Позиции к продаже</h1>
            <?php 
                if($err == 3){
                    ?> 
                        <p>Вы можете добавить ещё позицию или <a class="blue" href="sold.php">завершить</a></p>
                    <?php
                }
            ?>
            <br>
            <form action="" method="post">
                <select class="inplogin" name="sklad">
                    <?php
                        $recv=$conn->query("select * from `sklad`");
                        foreach ($recv as $recv){
                            ?>
                                <option value="<?php echo $recv['id']; ?>"><?php echo $recv['name']; ?></option>
                            <?php
                        }
                    ?>
                </select><br>
                <select class="inplogin" name="good">
                    <?php
                        $recv=$conn->query("select * from `good`");
                        foreach ($recv as $recv){
                            ?>
                                <option value="<?php echo $recv['id']; ?>"><?php echo $recv['name']; ?></option>
                            <?php
                        }
                    ?>
                </select><br>
                <input placeholder="Количество" class="inp" type="number" name="colvo"><br>
                <button name="btn" class="btn" type="submit">Добавить</button>
            </form>
        </div>
   </div>
   <script>
    <?php
            if($err == 1){
                ?>
                alert('Заполните поля!');
                <?php
            }
            if($err == 2){
                ?>
                alert('Столько единиц товара нет на этом месте!');
                <?php
            }
        ?>
   </script>
</body>
</html>