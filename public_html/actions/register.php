<?php
try{
    if ( isset( $_POST['submit'] ) ) {
        
        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";

        $nickname = $_REQUEST['nickname'];
        $email = $_REQUEST['email'];
        $password = md5($_REQUEST['password']);
        $secondPassword = md5($_REQUEST['secondPassword']);

        if($password !== $secondPassword)
            throw new Exception('Senhas divergentes');

        $nickname = onlyAlphanumeric($nickname);
        $email = cleanEmail($email);

        $conn = openConnection();

        $stmt = $conn->prepare("select * from user where nickname = (?)");
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows != 0)
            throw new Exception('Nickname já em uso');

        $stmt = $conn->prepare("select * from user where email = (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows != 0)
            throw new Exception('Email já em uso');

        $stmt = $conn->prepare("insert into user values(null, (?),(?),(?), 0)");
        $stmt->bind_param("sss", $nickname, $email, $password);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows == 0)
            throw new Exception('Erro ao inserir dados no banco de dados');
        
        session_start();
        $_SESSION["loged"] = true;
        $_SESSION["user"] = $nickname;
        $_SESSION["adm"] = false;

        $stmt->close();
        $conn->close();

        header('Location: ' . getPrimaryUrl(getHttpRefer()));
    }else{
        header('Location: ' . getPrimaryUrl(getHttpRefer()));
        die();
    }
}catch(Exception $ex){
    header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode($ex->getMessage()) );
}
?>