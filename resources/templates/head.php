<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/comum.css" type="text/css">
    <link rel="stylesheet" href="./css/estilo.css" type="text/css">
    <link rel="stylesheet" href="./css/notchs.css" type="text/css">
    <link rel="stylesheet" href="./css/alert.css" type="text/css">
    <link rel="stylesheet" href="./css/loading.css" type="text/css">
    <link rel="stylesheet" href="./css/header.css" type="text/css">
    <script src="./js/alert.js"></script>
    <script src="./js/base64Reader.js"></script>
    <script src="./js/loading.js"></script>
    <title><?php echo $pageTitle ?></title>

    <script>
        if (typeof alertMessage !== 'undefined') {
            popAlert(alertMessage);
        }
    </script>
    <div id="loading" class="display-none">
        <div id="loading-circle"></div>
        <a>Carregando...</a>
    </div>
</head>