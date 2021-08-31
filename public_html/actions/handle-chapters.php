<?php
try{
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";
        include RESOURCES_ROOT . "/templates/adm-page.php";

        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'), true);

        $conn = openConnection();

        if($data["valor"] == 0){
            $stmt = $conn->prepare("insert into `capitulo` (`Id`, `IdManga`, `Titulo`, `Desc`) values (null, (?), null, null)");
            $stmt->bind_param("i", $data["manga"]);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->affected_rows == 0){
                echo json_encode([
                    'error' => $stmt->error,
                    'status'=> 500,
                ]);
            }else{
                echo json_encode([
                    'error' => '',
                    'status'=> 200,
                ]);
            }
        }else{
            $stmt = $conn->prepare("delete from capitulo where `IdManga` = (?) and `Id` = (?)");
            $stmt->bind_param("ii", $data["manga"], $data["valor"]);
            $stmt->execute();
            if($stmt->affected_rows == 0){
                echo json_encode([
                    'error' => $stmt->error,
                    'status'=> 500,
                ]);
            }
            $stmt = $conn->prepare("delete from pagina where `IdCapitulo` = (?)");
            $stmt->bind_param("i", $data["valor"]);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        die();
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>