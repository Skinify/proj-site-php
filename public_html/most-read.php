<?php include "../resources/templates/base.php"; ?>
<html lang="pt-br">
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Manga Online - Mais lidos'));?>
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
        <?php
            include("../resources/templates/login-modal.php");
        ?>
    </body>
</html>