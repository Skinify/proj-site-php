<div class="content-section">
    <div class="section-title">
        <h2 class="<?php echo $sectionNotch ?>"><?php echo $sectionTitle ?></h2>
    </div>
    <div class="section-body">
        <?php 
        if(isset($sectionItems)){
            if(count($sectionItems) > 0){
                foreach ($sectionItems as $value){
                    $capa = $value['capa'];
                    $nome = $value['nome'];
                    $id = $value['id'];
                    includeWithVariables(RESOURCES_ROOT . "/templates/manga.php", array('id' => $id, 'capa' => $capa, 'nome' => $nome));
                }
            }else{
                echo "<a id='empty-result'>Desculpe, não encontramos nada ;(</a>";
            }
        }else{
            echo "<a id='empty-result'>Desculpe, não encontramos nada ;(</a>";
        }
        ?>
    </div>
</div>