<?php
    include RESOURCES_ROOT . "/utils/includeWithVariables.php";
    include RESOURCES_ROOT . "/utils/stringClean.php";
    include RESOURCES_ROOT . "/utils/base64Verify.php";
    include RESOURCES_ROOT . "/utils/url.php";

    function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
    
?>