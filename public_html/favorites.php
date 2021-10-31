<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mangá Online - Mues favoritos'));?>
    <body>
        <?php 
            include("../resources/templates/header.php");

            $favorited = [];
            $conn = openConnection();
            $stmt = $conn->prepare("SELECT B.Id, B.Nome, B.Capa FROM `favoritados` A inner join manga B on A.MangaId = B.Id WHERE A.UserId = (?)");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $nome, $capa);
            if($stmt->num_rows > 0){
                while($stmt->fetch()){
                    array_push($favorited, [
                        'id' => $id,
                        'nome' => $nome,
                        'capa' => $capa
                    ]);
                }
            }

        ?>
        <div id="content" style="box-shadow:none; margin-top:180px;">
            <?php
                includeWithVariables("../resources/templates/section.php", array(
                    'sectionTitle' =>  'Meus favoritos',
                    'sectionNotch' => 'saitama-notch',
                    'errorMessage' => 'Você ainda não possui nada favoritado',
                    'sectionItems' => $favorited
                ));
            ?>
        </div>
    </body>
</html>