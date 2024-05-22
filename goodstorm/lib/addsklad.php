<?php
    require_once '../settings/db.php';
    require_once '../settings/rootway.php';

    $prepReg=$conn->prepare("insert into `good_sklad` (`colvo`, `good_id`, `sklad_id`) values (?,?,?)");
$prepReg=$prepReg->execute(array($_POST['colvo'], $_POST['good'], $_POST['sklad']));

if ($_POST['rpt'] == 1){
    header(rootway() . "thegood.php?id=" . $_POST['good']);
}else{
    header(rootway() . "thesklad.php?id=" . $_POST['sklad']);
}

?>