<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<?php

    $s = "";
    $queries = array();
    parse_str($_SERVER['QUERY_STRING'], $queries);
    if(array_key_exists('v', $queries)){
        $s = clean($queries['v']);
    }else{
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Manga Online - Mais lidos'));?>

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
                includeWithVariables("../resources/templates/section.php", array(
                    'sectionTitle' =>  "Resultados da pesquisa '${s}'",
                    'sectionNotch' => 'naruto-notch'
                ));
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