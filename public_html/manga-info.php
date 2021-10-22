<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php 
    
        $querySearch = array();
        $capitulos = [];
        parse_str($_SERVER['QUERY_STRING'], $querySearch);
        if(array_key_exists('id', $querySearch)){
            $conn = openConnection();
            $stmt = $conn->prepare("SELECT Nome, A.Desc, Autor, Capa, B.Genero FROM `manga` A inner join genero B on A.IdGenero = b.Id WHERE A.Id = (?)");
            $stmt->bind_param("i", $querySearch['id']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($nome, $desc,$autor, $capa, $genero);
            if($stmt->num_rows == 0){
                header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode('Desculpe, não econtramos esse manga.') );
            }else{
                while($stmt->fetch()){}
                $conn = openConnection();
                $stmt = $conn->prepare("select count(A.Id), B.Titulo, B.Ordem from pagina A inner join capitulo B on A.IdCapitulo = B.Id inner join manga C on B.IdManga = C.Id where C.Id = (?) group by C.Id, B.Titulo, B.Ordem order by B.Ordem asc");
                $stmt->bind_param("i", $querySearch['id']);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($qtdPaginas, $tituloCapitulo, $ordemCapitulo);
                while($stmt->fetch()){
                    array_push($capitulos, [
                        'qtdPaginas' => $qtdPaginas,
                        'tituloCapitulo' => $tituloCapitulo,
                        'ordemCapitulo' => $ordemCapitulo
                    ]);
                }
            }
        }else{
            header('Location: ' . getPrimaryUrl(getHttpRefer()) . '?alertMessage=' .base64_encode('Desculpe, não econtramos esse manga.') );
        }
    ?>
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => "Mangá - $nome"));?>

<body>
    <?php 
            include("../resources/templates/header.php");
        ?>
    <div id="content" style="box-shadow:none; margin-top:180px;">
        <div id="manga-info-container">
            <div id="manga-info-image">
                <img src="<?php echo $capa ?>" />
                <div id="manga-info">
                    <a id="manga-info-title"><?php echo $nome ?></a>
                    <a id="manga-info-autor"><?php echo $autor ?></a>
                    <a id="manga-info-other"><?php echo $genero ?></a>
                    <a id="manga-info-other"><?php echo $desc ?></a>
                </div>
            </div>
            <div>
                <?php
                        $mangaId = $querySearch['id'];
                        foreach ($capitulos as $value){
                            $tituloCapitulo = $value['tituloCapitulo'];
                            $qtdPaginas = $value['qtdPaginas'];
                            $ordemCapitulo = $value['ordemCapitulo'];
                            echo "<div class='capitulo-info' onclick='readManga($mangaId,$ordemCapitulo)'><a>$tituloCapitulo</a> <a class='capitulo-info-pags'>$qtdPaginas paginas</a></div>";
                        }
                    ?>
            </div>
        </div>
    </div>
</body>
<script>
function readManga(mangaId, ordem){
    window.location.href = `read-manga.php?id=${mangaId}&pag=1&cap=${ordem}`
}
</script>
</html>
