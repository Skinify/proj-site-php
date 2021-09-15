<?php
try{
    if ( isset( $_POST['submit'] ) ) {
        session_start();



        include dirname(__DIR__, 2) . "/resources/env.php";

        include RESOURCES_ROOT . "/connection/mysqlConnection.php";
        include RESOURCES_ROOT . "/utils/utils.php";

        $nickname = $_REQUEST['nickname'];
        $password = md5($_REQUEST['password']);

        $nickname = onlyAlphanumeric($nickname);

        $conn = openConnection();

        $stmt = $conn->prepare("select * from user where nickname = (?) and password = (?)");
        $stmt->bind_param("ss", $nickname, $password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r1,$r2,$r3,$r4,$r5);

        if($stmt->num_rows == 0)
            throw new Exception('Usuario ou senha incorretos');

        $_SESSION["loged"] = true;
        $hash = md5($r1.$r2.$r3.$r4.$r5);
        $_SESSION["token"] = md5($r1 . $r2 . $r3 . $r4 . $r5);
        $_SESSION["user"] = $nickname;

        while($stmt->fetch()){
            $_SESSION["adm"] = $r5 == 1;
        }

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