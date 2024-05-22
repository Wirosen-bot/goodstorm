<?php
    require_once '../settings/db.php';
    require_once '../settings/rootway.php';

    $prepReg=$conn->prepare("delete from `user` where `id` = ?");
$prepReg=$prepReg->execute(array($_GET['p']));

header(rootway() . "panel.php");
?>