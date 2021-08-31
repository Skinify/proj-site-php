<?php
try{
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";
        include RESOURCES_ROOT . "/templates/adm-page.php";

        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        $array = [];
        $r1 = "";
        $conn = openConnection();

        $stmt = $conn->prepare("select `id` from capitulo where `IdManga` = (?)");
        $stmt->bind_param("i", $data["manga"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r1);

        if($stmt->num_rows == 0){
            echo json_encode([
                'error' => $stmt->error,
                'status'=> 500,
            ]);
        }else{
            while($stmt->fetch()){
                array_push($array, $r1);
                //var_dump($array);
            }
            echo json_encode([
                'error' => $stmt->error,
                'status' => 200,
                'data' => $array
            ]);
        }

        $stmt->close();
        $conn->close();

        die();
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>