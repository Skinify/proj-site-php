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

        if(!isset($id)){
            $stmt = $conn->prepare("insert into genero values(null, (?))");
            $stmt->bind_param("s", $titulo);
        }else{
            $editando = true;
            $stmt = $conn->prepare("update genero set `genero` = (?) where `id` = (?)");
            $stmt->bind_param("si", $titulo, $id);
        }


        $stmt->execute();
        $stmt->store_result();

        if($stmt->affected_rows == 0){
            if($editando){
                throw new Exception("Não foi possivel editar a categoria");
            }else{
                throw new Exception("Não foi possivel adicionar a categoria");
            }
        }

        $stmt->close();
        $conn->close();

        header('Location: ' . '../list-categorias.php' . '?alertMessage=' .base64_encode("Sucesso") );
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}

?>