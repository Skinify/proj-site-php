<?php
try{
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";
        include RESOURCES_ROOT . "/templates/adm-page.php";

        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        $r1 = "";
        $r2 = "";
        $r3 = "";
        $r4 = "";
        $r5 = "";
        $pages = [];
        $conn = openConnection();

        $stmt = $conn->prepare("select * from capitulo where `Id` = (?)");
        $stmt->bind_param("i", $data["capituloId"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r1, $r2, $r3, $r4);

        if($stmt->num_rows == 0){
            echo json_encode([
                'error' => $stmt->error,
                'status'=> 500,
            ]);
        }else{
            while($stmt->fetch()){ }
        }
        

        $stmt = $conn->prepare("select `Imagem` from pagina where `IdCapitulo` = (?)");
        $stmt->bind_param("i", $data["capituloId"]);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r5);
        
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                array_push($pages, $r5);
            }
        }


        echo json_encode([
            'error' => $stmt->error,
            'status' => 200,
            'data' => [
                'Id' => $r1,
                'IdManga' => $r2,
                'Titulo' => $r3,
                'Desc' => $r4,
                'Pages' => $pages,
            ]
        ]);

        $stmt->close();
        $conn->close();

        die();
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>