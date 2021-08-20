<?php
    include "../resources/utils/includeWithVariables.php";



    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

        return  str_replace('-', ' ', $string) ; // Removes special chars.
     }


?>