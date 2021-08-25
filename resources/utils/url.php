<?php

    function getHttpRefer(){
        if(isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }
        else
        {
            return 'index.php';
        }
    }

    function getPage(){
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

    function getPrimaryUrl($string){
        
        $exp = explode(".php", $string);
        $r = $exp[0] . ".php";

        if(str_contains($r, '/.php')){
            $r = str_ireplace('%/.php%', "/index.php", $r);
        }

        return $r;
    }
?>