<?php
    require_once '../settings/db.php';
    require_once '../settings/rootway.php';

    if($_POST['colvo'] > 0 && $_POST['colvo'] != ""){
    $prepReg=$conn->prepare("update `good_sklad` set `colvo` = ? where `good_id` = ? AND `sklad_id` = ?");
$prepReg=$prepReg->execute(array($_POST['colvo'], $_POST['good'], $_POST['sklad']));

    }else{
        $prepReg=$conn->prepare("delete from `good_sklad` where `good_id` = ? AND `sklad_id` = ?");
        $prepReg=$prepReg->execute(array($_POST['good'], $_POST['sklad']));
    }

    if ($_POST['rpt'] == 1){
        header(rootway() . "thegood.php?id=" . $_POST['good']);
    }else{
        header(rootway() . "thesklad.php?id=" . $_POST['sklad']);
    }

?>