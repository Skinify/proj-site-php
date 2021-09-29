<?php
try{
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";
      
        $conn = openConnection();

        $stmt = $conn->prepare("SELECT Id FROM `manga`");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r1);
        $arr = [];

        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                array_push($arr,  $r1);
            }
        }

        $rnd = rand(0,count($arr) - 1);

        $stmt->close();
        $conn->close();

        header("Location: ../read-manga.php?id={$arr[$rnd]}");

        die();
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>