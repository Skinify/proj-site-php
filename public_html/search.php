<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<?php

    $s = "";
    $querySearch = array();
    $array = [];
    $r1 = "";$r2 = "";$r3 = "";$r4 = "";
    parse_str($_SERVER['QUERY_STRING'], $querySearch);
    if(array_key_exists('v', $querySearch)){
        $s = clean($querySearch['v']);
        $conn = openConnection();
        $stmt = $conn->prepare("select `Id`, `Nome`, `Capa` from manga where Nome like (?)");
        $newParameter='%'.$s.'%';
        $stmt->bind_param("s", $newParameter);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r1, $r2, $r3);
        if($stmt->num_rows == 0){
            echo "<script> popAlert('O manga não possui capitulos ainda'); </script>";
        }else{
            while($stmt->fetch()){
                array_push($array, [
                    'id' => $r1,
                    'nome' => $r2,
                    'capa' => $r3
                ]);
            }
        }
        

    }

?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mangá Online - Pesquisa'));?>

<body>
    <?php 
            include("../resources/templates/header.php");
        ?>
    <div id="big-search">
        <div>
            <input type="text" value="<?php echo $s; ?>" id="big-search-input" onfocus="bigSearchEventListener(true)"
                onfocusout="bigSearchEventListener(false)" />
            <a onClick="doSearch()"></a>
        </div>
    </div>

    <div id="content" style="box-shadow:none; margin-top:180px;">
        <?php
                if($s !== ""){
                    includeWithVariables("../resources/templates/section.php", array(
                        'sectionTitle' =>  "Resultados da pesquisa '${s}'",
                        'sectionNotch' => 'ryuk-notch',
                        'sectionItems' => $array
                    ));
                }
        ?>
    </div>

    <script>
        const doSearch = function () {
            let sValue = bigSearchInput.value.replace(/<.*?>/, "");
            if (sValue !== "" && sValue !== " ")
                window.location.href = './search.php?v=' + sValue;
        }

        const bigSearchInput = document.querySelector("#big-search-input");
        const bigSearchEvent = function (e) {
            if (e.keyCode === 13) {
                doSearch();
            }
        }

        const bigSearchEventListener = function (e) {
            if (e) {
                bigSearchInput.addEventListener("keyup", bigSearchEvent)
            } else {
                bigSearchInput.removeEventListener('keyup', bigSearchEvent, false);
            }
        }
    </script>
</body>

</html>