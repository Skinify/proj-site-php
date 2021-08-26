<?php
try{
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";
        include RESOURCES_ROOT . "/templates/adm-page.php";

        $queries = array();
        parse_str($_SERVER['QUERY_STRING'], $queries);
        if(array_key_exists('id', $queries)){
            $id = clean($queries['id']);
        }

        $conn = openConnection();

        $stmt = $conn->prepare("delete from manga where id = (?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->affected_rows == 0)
            throw new Exception('Não foi possivel excluir o manga');

        $stmt->close();
        $conn->close();

        header('Location: ' . getPrimaryUrl(getHttpRefer()));
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>