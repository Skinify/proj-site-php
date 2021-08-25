<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>
    <body>
        <?php 
            include("../resources/templates/header.php");
        ?>
        <div id="splash-screen">
            <div id="splash-screen-background"></div>
            <div id="title-container">
                <a id="first-title">Manga</a>
                <a id="second-title">Online</a>
                <img src="./img/crown.png" id="title-notch" />
            </div>
        </div>
        <div id="content">
            <?php
                includeWithVariables("../resources/templates/section.php", array(
                    'sectionTitle' => 'Catalogo',
                    'sectionNotch' => 'naruto-notch'
                ));
            ?>
        </div>
    </body>
</html>