<?php
 function isBase64($s)
 {
       return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
 }
?>