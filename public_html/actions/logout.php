<?php

   include dirname(__DIR__, 2) . "/resources/env.php";

   include RESOURCES_ROOT . "/connection/mysqlConnection.php";
   include RESOURCES_ROOT . "/utils/utils.php";

   session_start();
   session_destroy();
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   exit();
?>