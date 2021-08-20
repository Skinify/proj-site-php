<?php 
    include "../resources/config.php";

    $conn = null;

    function openConnection(){
        global $servername;
        global $username;
        global $password;
        global $db;
        global $conn;
        
        if(!is_null($conn)){
            if($conn->ping()){
                return $conn;
            }
        }
        else{
            $conn = new mysqli($servername, $username, $password, $db);
        }
        
        if ($conn->connect_error) {
            throw new Exception('Erro ao se conectar ao banco de dados');
        }

        return $conn;
    }

    function executeQuerySingle($query, $closeConnection = true) {
        $conn = openConnection();
        $result= $conn->query($query);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $result->close();

            if($closeConnection)
            $conn->close();

            return $row;
        }

        return null;
    }

    function executeQuery() {

    }
?>