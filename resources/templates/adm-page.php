<?php

    if(session_status() == 0 ||  session_status() == 1)
        header('Location: ./index.php');

    $logado = false;
    $adm = false;

    if(isset($_SESSION["loged"])){
        $logado = $_SESSION["loged"];
        $user = $_SESSION["user"];
        $adm = $_SESSION["adm"];

        //REQUEST VERIFICANDO SE É ADM MESMO
    }

    if($adm == false)
        header('Location: ./index.php');

?>