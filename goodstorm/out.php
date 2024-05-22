<?php
// Выход из аккаунта
session_start();
session_destroy();
include "settings/rootway.php";
header(rootway());
exit();
?>