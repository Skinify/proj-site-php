<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");


            $editing = false;

            $r1 = ""; $r2= "";
            $queries = array();
            parse_str($_SERVER['QUERY_STRING'], $queries);
            if(array_key_exists('id', $queries)){
                $editing = true;
                $id = clean($queries['id']);
                $conn = openConnection();
                $stmt = $conn->prepare("select * from genero where id = (?)");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($r1,$r2);

                if($stmt->num_rows == 0){
                    $editing = false;
                    echo "<script> popAlert('O genero não existe'); </script>";
                }else{
                    $editing = true;
                    while($stmt->fetch()){}
                }
            }
        ?>


    <form class="default-form" action="actions/handle-genero.php" method="post">
        <div>
            <?php
                if($editing){
                    echo "
                        <label for='id'>Id</label>
                        <input readonly name='id' id='id' value='{$r1}' type='text'>
                    ";
                }
            ?>
            <label for="titulo">Genero</label>
            <input id="titulo" name="titulo" type="text" value='<?php echo $r2?>' required>
            <?php
                if($editing){
                    echo "<button>Salvar</button>";
                }else{
                    echo "<button>Adicionar</button>";
                }
            ?>
        </div>
    </form>
</body>

</html>