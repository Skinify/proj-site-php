<?php

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

    return  str_replace('-', ' ', $string) ; // Removes special chars.
 }

 function onlyAlphanumeric($string){
    return preg_replace('/[^[:alpha:]_]/', '', $string);
 }

 function cleanEmail($string){
    return preg_replace('/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+\.([a-z]+)?$/i', '', $string);
 }

 function isBase64($s)
   {
         return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
   }

?>