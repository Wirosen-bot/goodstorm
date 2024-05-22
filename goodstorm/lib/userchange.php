<?php
    require_once '../settings/db.php';
    require_once '../settings/rootway.php';

    $prepReg=$conn->prepare("update `user` set `role` = ? where `id` = ?");
$prepReg=$prepReg->execute(array($_POST['role'], $_POST['user']));

header(rootway() . "panel.php");
?>
