<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>
    <body>
        <?php 
            include("../resources/templates/header.php");
            $array = [];
            $conn = openConnection();
            $stmt = $conn->prepare("SELECT `Id`, `Nome`, `Capa` FROM manga order by Id desc LIMIT 20");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r1, $r2, $r3);
            if($stmt->num_rows == 0){
                echo "<script> popAlert('Ainda não existem itens cadastrados na base de dados'); </script>";
            }else{
                while($stmt->fetch()){
                    array_push($array, [
                        'id' => $r1,
                        'nome' => $r2,
                        'capa' => $r3
                    ]);
                }
            }

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
                    'sectionNotch' => 'naruto-notch',
                    'sectionItems' => $array
                ));
            ?>
        </div>
    </body>
</html>