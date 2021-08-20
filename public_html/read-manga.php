<?php include "../resources/templates/base.php"; ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Manga Online - Ler'));?>

<body>
    <?php 
        include("../resources/templates/header.php");
    ?>
    <div id="splash-screen-background" style="filter:blur(0px) brightness(0.1)" class="full-splash"></div>
    <div id="manga-paper"
        style="background-image: url('./img/mangas-pages/anime-1/cap-1/1.png');"
    ></div>
    <div id="manga-controls">
        <div><button>-</button> <a>Luminosidade</a> <button>+</button> </div>
        <div>
            <button onClick="changePage(-1)"><</button>
            <a>Pagina</a>
            <button onClick="changePage(1)">></button>
        </div>
        <div>
            <button onClick="changeCap(-1)"><</button>
                 <a>Capitulo</a> 
            <button onClick="changeCap(1)">></button>
        </div>
    </div>

<script>
    const mangaPaper = document.querySelector('div#manga-paper');

    let currentPage = 1;
    let maxPages = 10;
    let currentCap = 1;
    let maxCaps = 10;
    let animeName = 'anime-1'

    const changePage = function(cmd){
        if((currentPage + cmd) > maxPages || (currentPage + cmd) < 1)
            return;

        currentPage += cmd;
        mangaPaper.style.backgroundImage =  `url('./img/mangas-pages/${animeName}/cap-${currentCap}/${currentPage}.png')`
    }

    const changeCap = function(cmd){
        if((currentCap + cmd) > maxCaps || (currentCap + cmd) < 1)
            return;

        currentPage = 1;
        currentCap += cmd;
        mangaPaper.style.backgroundImage =  `url('./img/mangas-pages/${animeName}/cap-${currentCap}/${currentPage}.png')`
    }

</script>

</body>

</html>