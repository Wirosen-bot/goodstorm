<?php
    require_once '../settings/db.php';
    require_once '../settings/rootway.php';
    
    $prepReg=$conn->prepare("delete from `good_sklad` where `sklad_id` = ?");
    $prepReg=$prepReg->execute(array($_GET['id']));
    $prepReg=$conn->prepare("delete from `sklad` where `id` = ?");
    $prepReg=$prepReg->execute(array($_GET['id']));

    header(rootway() . "sklad.php");
?>