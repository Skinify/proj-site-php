<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php 
        $queries = array();
        parse_str($_SERVER['QUERY_STRING'], $queries);
    ?>
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => array_key_exists('category', $queries) ? clean("Manga Online - {$queries['category']}") : 'Categoria' ));?>
    <body>
        <?php 
            include("../resources/templates/header.php");
        ?>
        <div id="content" style="box-shadow:none; margin-top:180px;">
            <?php
                includeWithVariables("../resources/templates/section.php", array(
                    'sectionTitle' =>  array_key_exists('category', $queries) ? clean("Catalogo de {$queries['category']}") : "Catalogo",
                    'sectionNotch' => 'naruto-notch'
                ));
            ?>
        </div>
    </body>
</html>