<?php
    function getPrimaryUrl($string){
        
        $exp = explode(".php", $string);
        $r = $exp[0] . ".php";
        return $r;
    }
?>