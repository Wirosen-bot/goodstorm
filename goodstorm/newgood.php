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
    if($_POST['name'] != '' && $_POST['cost'] != ''){
        if($_POST['cost'] > 0){
            if (isset($_FILES['img']) && !empty($_FILES['img']['name'])){

                $avatarName=$_FILES['img']['name'];
                
                $extension=pathinfo($avatarName, PATHINFO_EXTENSION);
                
                $avatarNewName=md5(time()).'.'.$extension;
                move_uploaded_file($_FILES['img']['tmp_name'], 'photo/'.$avatarNewName);
                }else{
                $avatarNewName = 'nophoto.png';
                }
                $text = str_replace("\r\n", "<br>", $_POST['about']);
                $prepReg=$conn->prepare("insert into `good` (`name`, `img`, `about`, `cost`) values (?,?,?,?)");
                $prepReg=$prepReg->execute(array($_POST['name'], $avatarNewName, $text, $_POST['cost']));
                $c=$conn->query("select `id` from `good` order by `id` desc limit 1");
                $c=$c->fetch();
                header(rootway() . "thegood.php?id=" . $c['id']);
                exit();
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
            <h1>Новый товар</h1>
            <br>
            <form action="" method="post" enctype="multipart/form-data">
                <input value="<?php echo $_POST['name']; ?>" placeholder="Название" class="inp" type="text" name="name"><br>
                <input value="<?php echo $_POST['cost']; ?>" step="0.01" placeholder="Цена" class="inp" type="number" name="cost"><br>
                <input class="inp" type="file" name="img"><br>
                <textarea class="inp" placeholder="Описане товара" name="about" id="" cols="30" rows="10"><?php echo $_POST['about']; ?></textarea><br>
                <button name="btn" class="btn" type="submit">Добавить товар</button>
            </form>
        </div>
   </div>
   <script>
    <?php
            if($err == 1){
                ?>
                alert('Заполните поля "Название" и "Цена"!');
                <?php
            }
            if($err == 3){
                ?>
                alert('Недопустимое значение Цены!');
                <?php
            }
        ?>
   </script>
</body>
</html>