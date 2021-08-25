<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>
    <body>
        <?php 
            include(RESOURCES_ROOT . "/templates/header.php");
            include(RESOURCES_ROOT . "/templates/adm-page.php");

        ?>
    </body>
</html>