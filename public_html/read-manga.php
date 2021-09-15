<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mangá Online - Ler'));?>

<body>
    <?php 
        include("../resources/templates/header.php");

        $queryParams = array();
        $cap = 1;
        $pag = 1;
        parse_str($_SERVER['QUERY_STRING'], $queryParams);
        if(array_key_exists('id', $queryParams)){
            if(array_key_exists('cap', $queryParams)){
                $cap = $queryParams['cap'];
            }

            if(array_key_exists('pag', $queryParams)){
                $pag = $queryParams['pag'];
            }

            $conn = openConnection();
            $stmt = $conn->prepare("select `Imagem` from manga A inner join capitulo B on A.Id = B.IdManga inner join pagina C on B.Id = C.IdCapitulo where B.Ordem = (?) and C.Ordem = (?) and A.Id = (?)");
            $stmt->bind_param("iii",$cap, $pag, $queryParams['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r1);
            if($stmt->num_rows == 0){
                echo "<script> window.location.href='error.php'; </script>";
            }else{
                $stmt->fetch();
            }

            $stmt = $conn->prepare("select count(A.Id) as MaxCapitulos, (select COUNT(P.Id) from pagina P inner join capitulo B on P.IdCapitulo = B.Id where B.IdManga = (?)) as MaxPaginas from capitulo A where A.IdManga = (?)");
            $stmt->bind_param("ii",$queryParams['id'], $queryParams['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($maxCap, $maxPag);
            $stmt->fetch();
            echo "<script>
                let currentPage = $pag;
                let currentCap = $cap;
                let maxCaps = $maxCap;
                let maxPages = $maxPag; 
                </script>";
        } 


    ?>
    <div id="splash-screen-background" style="filter:blur(0px) brightness(0.1)" class="full-splash"></div>
    <div id="manga-paper"
        style="background-image: url('<?php echo $r1;?>');"
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
    let animeName = 'anime-1'

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const mangaId = urlParams.get('id');

    const changePage = function(cmd){
        if((currentPage + cmd) > maxPages || (currentPage + cmd) < 1)
            return;

        currentPage += cmd;
        window.location.href = `read-manga.php?id=${mangaId}&pag=${currentPage}&cap=${currentCap}`
    }

    const changeCap = function(cmd){
        if((currentCap + cmd) > maxCaps || (currentCap + cmd) < 1)
            return;

        currentPage = 1;
        currentCap += cmd;
        window.location.href = `read-manga.php?id=${mangaId}&pag=${currentPage}&cap=${currentCap}`
    }

</script>

</body>

</html>