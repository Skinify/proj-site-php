<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");


            $array = [];
            $r6 = "";
            $r7 = "";

            $conn = openConnection();
            $stmt = $conn->prepare("select * from genero");
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r6, $r7);
            if($stmt->num_rows == 0){
                $no_categories = true;
                echo "<script> popAlert('Ainda não existem nenhuma categoria, adicione alguma categoria para proseguir'); </script>";
            }else{
                $no_categories = false;
                while($stmt->fetch()){
                    array_push($array, [
                        "id" => $r6,
                        "genero" => $r7
                    ]);
                }
            }



            $editing = false;
            $no_categories = false;
            $r1 = ""; $r2= ""; $r3 = ""; $r4 = ""; $idGenero = ""; $genero = "";
            $queries = array();
            parse_str($_SERVER['QUERY_STRING'], $queries);
            if(array_key_exists('id', $queries)){
                $editing = true;
                $id = clean($queries['id']);
                $conn = openConnection();
                $stmt = $conn->prepare("SELECT A.`id`, `nome`, `desc`, `autor`, `capa`, `genero`, b.Id as `idGenero` FROM `manga` A inner join genero B on A.IdGenero = B.Id where A.id = (?)");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($r1,$r2,$r3,$r4,$r5, $genero, $idGenero);

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
            <input id="titulo" name="titulo" type="text" value='<?php echo $r2?>' required>
            <label for="categoria" required>Categoria</label>    
            <select style="margin-bottom:12px;" id="genero" name="genero" class="default-select" required>
                    <?php 
                        foreach ($array as $value){
                            $gen = $value['genero'];
                            $id = $value['id'];
                            if($idGenero == $id){
                                echo "<option selected value='$id'>$gen</option>";
                            }else{
                                echo "<option value='$id'>$gen</option>";
                            }
                            
                        }
                    ?>
                </select>
            <label for="autor">Autor</label>
            <input id="autor" type="text" name="autor" value='<?php echo $r3?>' required></input>
            <label for="desc">Descrição</label>
            <textarea id="desc" name="desc" required><?php echo $r4?></textarea>
            <?php
                if($editing){
                    echo $no_categories ? "<button disabled>Salvar</button>" : "<button>Salvar</button>";
                }else{
                    echo $no_categories ? "<button disabled>Adicionar</button>" : "<button>Adicionar</button>";
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

            const changeImage = async function(e){
                document.querySelector("#capa-thumb").src = await base64Reader(e[0])
                document.querySelector("#capa-base").value = await base64Reader(e[0])
            }

    </script>
</body>

</html>