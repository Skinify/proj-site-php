<?php

    include dirname(__DIR__, 1) . "/env.php";

    include RESOURCES_ROOT . "/utils/utils.php";
    include RESOURCES_ROOT . "/connection/mysqlConnection.php";


    $queries = array();
    parse_str($_SERVER['QUERY_STRING'], $queries);

    if(array_key_exists('alertMessage', $queries)){
        if(isBase64($queries['alertMessage'])){
            $param = base64_decode($queries['alertMessage']);
            echo "
                <script>
                    var alertMessage = '$param';
                </script>
            ";
        }
    }; 

?>
<!DOCTYPE html>