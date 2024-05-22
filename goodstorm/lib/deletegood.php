<?php
    require_once '../settings/db.php';
    require_once '../settings/rootway.php';
    
    $prepReg=$conn->prepare("delete from `good_sklad` where `good_id` = ?");
    $prepReg=$prepReg->execute(array($_GET['id']));
    $prepReg=$conn->prepare("delete from `good` where `id` = ?");
    $prepReg=$prepReg->execute(array($_GET['id']));

    header(rootway() . "good.php");
?>