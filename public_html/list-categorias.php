<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");
        ?>


    <div class="table-container">
            <a href="add-genero.php">Adicionar novo genero</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Genero</th>
                <th>Ações</th>
            </tr>
            <?php

            $conn = openConnection();

            $stmt = $conn->prepare("select `id`, `genero` from genero");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r1,$r2);


            if($stmt->num_rows == 0)
                echo '
                    <tr> <td colspan="4">Não existem registros</td> </tr>
                ';

            while($stmt->fetch()){
                echo "<tr>
                            <td>{$r1}</td>
                            <td>{$r2}</td>
                            <td><button><a href='actions/exclude-genero.php?id={$r1}'>Excluir</a></button></td>
                        </tr>";
            }

            ?>
        </table>
    </div>
</body>

</html>