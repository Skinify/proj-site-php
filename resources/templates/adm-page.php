<?php
    if(session_status() == 0 ||  session_status() == 1)
        session_start();

    if(isset($_SESSION["adm"])){
        if($_SESSION["adm"] == false){
            if(in_array(getPage(),  RESTRICT_PAGES)){
                header('Location: ' . 'index.php' . '?alertMessage=' .base64_encode('Acesso proibido') );    
            }else{
                header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode('Acesso proibido') );
            }
            
        }
    }else{
        if(in_array(getPage(),  RESTRICT_PAGES)){
            header('Location: ' . 'index.php' . '?alertMessage=' .base64_encode('Acesso proibido') );    
        }else{
            header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode('Acesso proibido') );
        }
    }
?>