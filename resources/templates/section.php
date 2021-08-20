<div class="content-section">
    <div class="section-title">
        <h2 class="<?php echo $sectionNotch ?>"><?php echo $sectionTitle ?></h2>
    </div>
    <div class="section-body">
        <?php for($i = 1; $i <= 12; $i++){
            echo '
                <a class="manga" href="read-manga.php">
                    <img src="./img/mangas-thumb/naruto-manga-thumb.jpg">
                    <p>Naruto</p>
                </a>
            ';
        }?>
    </div>
</div>