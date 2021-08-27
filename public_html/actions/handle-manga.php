<?php
try{
        session_start();

        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";
        include RESOURCES_ROOT . "/templates/adm-page.php";

        $sql = "";
        $editando = false;
        $conn = openConnection();

        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
        }

        $titulo = $_REQUEST['titulo'];
        $autor = $_REQUEST['autor'];
        $desc = $_REQUEST['desc'];
        if(!isset($id)){
            $stmt = $conn->prepare("insert into manga values(null, (?), (?), (?))");
            $stmt->bind_param("sss", $titulo, $autor, $desc);
        }else{
            $editando = true;
            $stmt = $conn->prepare("update manga set `nome` = (?), `autor` = (?), `desc` = (?) where `id` = (?)");
            $stmt->bind_param("sssi", $titulo, $autor, $desc, $id);
        }

        $stmt->execute();
        $stmt->store_result();

        if($stmt->affected_rows == 0){
            if($editando){
                throw new Exception("Não foi possivel editar o manga");
            }else{
                throw new Exception("Não foi possivel adicionar o manga");
            }
        }

        header('Location: ' . '../list-mangas.php' . '?alertMessage=' .base64_encode("Sucesso") );

        $stmt->close();
        $conn->close();
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>