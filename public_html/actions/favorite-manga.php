

<?php
try{

        header('Content-Type: application/json');
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";

        $data = json_decode(file_get_contents('php://input'), true);

        $mangaId = $data["id"];
        $action = $data["fav"];

        $conn = openConnection();

        if($action){
            $stmt = $conn->prepare("INSERT INTO `favoritados` (`UserId`, `MangaId`) VALUES ((?), (?))");
            $stmt->bind_param("ii", $_SESSION["id"], $mangaId);
            $stmt->execute();
            //$stmt->store_result();
        }else{
            $stmt = $conn->prepare("DELETE FROM `favoritados` WHERE `UserId` = (?) AND `MangaId` = (?)");
            $stmt->bind_param("ii", $_SESSION["id"], $mangaId);
            $stmt->execute();
            //$stmt->store_result();
        }

        $stmt->close();
        $conn->close();

}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>
    