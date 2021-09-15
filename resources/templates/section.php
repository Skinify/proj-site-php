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
                    echo "
                    <a class='manga' href='read-manga.php?id=$id'>
                        <img src='$capa'>
                        <p>$nome</p>
                    </a>";
                }
            }else{
                echo "<a id='empty-result'>Desculpe, não encontramos nada ;(</a>";
            }
        }else{
            for($i = 1; $i <= 12; $i++){
                echo '
                    <a class="manga" href="read-manga.php">
                        <img src="./img/mangas-thumb/naruto-manga-thumb.jpg">
                        <p>Naruto</p>
                    </a>
                ';
            }
        }
        ?>
    </div>
</div>