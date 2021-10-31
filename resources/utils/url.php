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
        $r = "";
        try{
            $exp = explode(".php", $string);
            $r = $exp[0] . ".php";

            if(!function_exists('str_contains')){
                $r = "/public_html/index.php";
                return $r;
            }
    
            if(str_contains($r, '/.php')){
                $r = str_ireplace('%/.php%', "/index.php", $r);
            }
            
        }catch(Exception $ex){
            $r = "/index.php";
        }

        return $r;
    }

?>