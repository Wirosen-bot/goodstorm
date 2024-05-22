<?php
session_start();
require_once 'settings/db.php';
require_once 'settings/rootway.php';
$prepReg=$conn->prepare("insert into `sold` () values ()");
$prepReg=$prepReg->execute(array());
header(rootway() . "newsoldpos.php");
exit();
?>