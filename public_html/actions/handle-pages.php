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
        $stmt = $conn->prepare("delete from pagina where `IdCapitulo` = (?)");
        $stmt->bind_param("i", $data["data"]["capituloId"]);
        $stmt->execute();
        $stmt->store_result();

        foreach ($data["data"]["allPages"] as $value){
            $stmt = $conn->prepare("INSERT INTO `pagina` (`Id`, `IdCapitulo`, `Imagem`, `ordem`) VALUES (NULL, (?), (?), (?))");
            $stmt->bind_param("isi", $data["data"]["capituloId"], $value["img"], $value["ordem"]);
            $stmt->execute();
            var_dump($stmt->error);
        };

        $stmt = $conn->prepare("update capitulo set `Titulo` = (?), `Desc` = (?), `Ordem` = (?) where `Id` = (?)");
        $stmt->bind_param("ssii", $data["data"]["title"], $data["data"]["desc"], $data["data"]["ordem"], $data["data"]["capituloId"]);
        $stmt->execute();
        $stmt->store_result();

        echo json_encode([
            'error' => $stmt->error,
            'status'=> 200,
        ]);

        $stmt->close();
        $conn->close();
        die();
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>