<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mangá Online - Mais lidos'));?>
    <body>
        <?php 
            include("../resources/templates/header.php");
        ?>
        <div id="content" style="box-shadow:none; margin-top:180px;">
            <?php
                includeWithVariables("../resources/templates/section.php", array(
                    'sectionTitle' =>  'Mais lidos',
                    'sectionNotch' => 'naruto-notch'
                ));
            ?>
        </div>
    </body>
</html>