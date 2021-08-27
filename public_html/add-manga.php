<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");


            $editing = false;

            $r1 = ""; $r2= ""; $r3 = ""; $r4 = "";
            $queries = array();
            parse_str($_SERVER['QUERY_STRING'], $queries);
            if(array_key_exists('id', $queries)){
                $editing = true;
                $id = clean($queries['id']);
                $conn = openConnection();
                $stmt = $conn->prepare("select * from manga where id = (?)");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($r1,$r2,$r3,$r4);

                if($stmt->num_rows == 0){
                    $editing = false;
                    echo "<script> popAlert('O manga não existe'); </script>";
                }else{
                    $editing = true;
                    while($stmt->fetch()){}
                }
            }
        ?>


    <form id="add-manga-container" action="actions/handle-manga.php" method="post">
        <div>
            <?php
                if($editing){
                    echo "
                        <label for='id'>Id</label>
                        <input readonly name='id' id='id' value='{$r1}' type='text'>
                    ";
                }
            ?>
            <label for="titulo">Titulo</label>
            <input id="titulo" name="titulo" type="text" value='<?php echo $r2?>'>
            <label for="autor">Autor</label>
            <input id="autor" type="text" name="autor" value='<?php echo $r3?>'></input>
            <label for="desc">Descrição</label>
            <textarea id="desc" name="desc"><?php echo $r4?></textarea>
            <?php
                if($editing){
                    echo "<button>Salvar</button>";
                }else{
                    echo "<button>Adicionar</button>";
                }
            ?>
        </div>
        <div>
            <label style="text-align:center" for="file-input">Capa</label>
            <img src="./img/mangas-thumb/naruto-manga-thumb.jpg" />
            <input type="file" id="file-input" accept="image/png, image/jpeg"/>
        </div>
    </form>
</body>

</html>