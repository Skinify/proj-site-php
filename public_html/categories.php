<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
    <?php 
        $querySearch = array();
        $array = [];
        parse_str($_SERVER['QUERY_STRING'], $querySearch);
        if(array_key_exists('category', $querySearch)){
            $conn = openConnection();
            $stmt = $conn->prepare("SELECT A.`Id`, `Nome`, `Capa` FROM `manga` A inner join genero B on A.IdGenero = B.Id where B.Genero = (?)");
            $stmt->bind_param("s", $querySearch['category']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r1, $r2, $r3);
            if($stmt->num_rows == 0){
                echo "<script> popAlert('O manga não possui capitulos ainda'); </script>";
            }else{
                while($stmt->fetch()){
                    array_push($array, [
                        'id' => $r1,
                        'nome' => $r2,
                        'capa' => $r3
                    ]);
                }
            }
            
    
        }
    ?>
    <?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => array_key_exists('category', $queries) ? clean("Mangá Online - {$queries['category']}") : 'Categoria' ));?>
    <body>
        <?php 
            include("../resources/templates/header.php");
        ?>
        <div id="content" style="box-shadow:none; margin-top:180px;">
            <?php
                includeWithVariables("../resources/templates/section.php", array(
                    'sectionTitle' =>  array_key_exists('category', $queries) ? "Catalogo de {$queries['category']}" : "Catalogo",
                    'sectionNotch' => 'izuku-notch',
                    'sectionItems' => $array
                ));
            ?>
        </div>
    </body>
</html>