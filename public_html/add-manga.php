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
                $stmt->bind_result($r1,$r2,$r3,$r4,$r5);

                if($stmt->num_rows == 0){
                    $editing = false;
                    echo "<script> popAlert('O manga não existe'); </script>";
                }else{
                    $editing = true;
                    while($stmt->fetch()){}
                }
            }
        ?>


    <form class="default-form" action="actions/handle-manga.php" method="post">
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
            <input type="hidden" id="capa-base" name="capa-base" value="<?php echo isset($editing) && $editing == true ? $r5 : 'vazio'?>">
            <img src="<?php echo isset($editing) && $editing == true ? $r5 : './img/mangas-thumb/empty-thumb.png'?>" id="capa-thumb"/>
            <input type="file" name="capa" id="file-input" accept="image/png, image/jpeg" onChange="changeImage(this.files)"/>
        </div>
    </form>
    <script>

            const changeImage = function(e){
                base64Reader(e[0], (base) => document.querySelector("#capa-thumb").src = base)
                base64Reader(e[0], (base) => document.querySelector("#capa-base").value = base)
            }

    </script>
</body>

</html>