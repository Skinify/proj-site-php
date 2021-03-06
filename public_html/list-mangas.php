<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");
        ?>


    <div class="table-container">
            <a href="add-manga.php">Adicionar novo manga</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Autor</th>
                <th>Desc</th>
                <th>Genero</th>
                <th>Capitulos</th>
                <th>Ações</th>
            </tr>
            <?php

            $conn = openConnection();
            $stmt = $conn->prepare("SELECT A.`id`, `nome`, `desc`, `autor`, `genero` FROM `manga` A inner join genero B on A.IdGenero = B.Id");
            //$stmt->bind_param("ss", $nickname, $password);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r1,$r2,$r3,$r4, $r5);


            if($stmt->num_rows == 0)
                echo '
                    <tr> <td colspan="7">Não existem registros</td> </tr>
                ';

            while($stmt->fetch()){
                echo "<tr>
                            <td>{$r1}</td>
                            <td>{$r2}</td>
                            <td>{$r4}</td>
                            <td>{$r3}</td>
                            <td>{$r5}</td>
                            <td><button><a href='manga-chapters.php?id={$r1}'>Editar</a></button><button</td>
                            <td><button><a href='add-manga.php?id={$r1}'>Editar</a></button><button><a href='actions/exclude-manga.php?id={$r1}'>Excluir</a></button></td>
                        </tr>";
            }

            ?>
        </table>
    </div>
</body>

</html>