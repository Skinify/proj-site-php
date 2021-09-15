<?php

    if(session_status() == 0 ||  session_status() == 1)
        session_start();
    
    $logado = false;

    if(isset($_SESSION["loged"])){
        $logado = $_SESSION["loged"];
        $user = $_SESSION["user"];
        $token = $_SESSION["token"];
        $adm = $_SESSION["adm"];

        $conn = openConnection();

        $stmt = $conn->prepare("select * from user where nickname = (?)");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows == 0){
            echo "<script>popAlert('Sessão invalida por favor entre novamente')</script>";
        }else{
            $stmt->bind_result($r1_1,$r2_1,$r3_1,$r4_1,$r5_1);

            $hash = md5($r1_1.$r2_1.$r3_1.$r4_1.$r5_1);
    
            if($hash != $token){
                $logado = false;
                $user = null;
                $token = null;

                session_abort();

                echo "<script>popAlert('Sessão invalida por favor entre novamente')</script>";
            }
        }
    }


?>

<nav id="header" class="header-on-top">
    <a id="header-title" href="index.php">Mangá Online</a>
    <ul>
        <li>Leitura aleatoria</li>
        <li id="category">Categorias ▼
            <div id="category-dropbox">
                <ul>
                    <?php

                    $conn = openConnection();

                    $stmt = $conn->prepare("select `id`, `genero` from genero");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($r1,$r2);

                    if($stmt->num_rows == 0)
                        echo '<li><a>Não existem categorias</a></li>';

                    while($stmt->fetch()){
                        echo "<li><a href='categories.php?category=${r2}'>${r2}</a></li>";
                    }
                
                ?>
                </ul>
            </div>
        </li>
        <li id="search-div">
            <button id="search-btn" onclick="toggleSearch()"></button>
            <input type="text" onfocus="searchEventListener(true)" onfocusout="searchEventListener(false)"
                class="search-input" placeholder="Naruto" />
        </li>
        <?php
            if($logado == true && $adm == false){
                echo "      
                <li id='logged'>
                    Bem vindo {$user}
                    <div id='logged-dropbox'>
                        <ul>
                            <li><a>Minha conta</a></li>
                            <li><a>Favoritos</a></li>
                            <li><a href='actions/logout.php'>Sair</a></li>
                        </ul>
                    </div>
                </li>";
            }else if($logado == true && $adm == true){
                echo "      
                <li id='logged'>
                    Bem vindo {$user}
                    <div id='logged-dropbox'>
                        <ul>
                            <li><a>Minha conta</a></li>
                            <li><a>Favoritos</a></li>
                            <li><a href='list-mangas.php'>Alterar mangas</a></li>
                            <li><a href='list-categorias.php'>Alterar categorias</a></li>
                            <li><a href='actions/logout.php'>Sair</a></li>
                        </ul>
                    </div>
                </li>";
            }else{
                echo '        
                <li id="login-btn" onclick="openLogin()">
                    
                </li>';
            }
        ?>
    </ul>
</nav>
<nav id="header-mobile" class="header-on-top">
    <div id="logo-container">
        <button onclick="toggleLateralMenu()" id="btn-open-mobile-menu"></button>
        <a id="header-title" href="index.php">Mangá Online</a>
    </div>
    <div id="lateral-menu" class="d-flex">
        <ul>
            <li>Leitura aleatoria</li>
            <li>Categorias ▼</li>
        </ul>
    </div>
    <button id="mobile-search-btn"></button>
</nav>

<script>
    var windowDimensions = {}
    var lateralMenu = false;

    window.onresize = function (e) {
        windowDimensionsProxy.height = e.currentTarget.innerHeight
        windowDimensionsProxy.width = e.currentTarget.innerWidth
    }

    var windowDimensionsProxy = new Proxy(windowDimensions, {
        set: function (target, key, value) {
            if (key === "width" && value < 800) {
                toggleMobileMenu(true)
            } else {
                toggleMobileMenu(false)
            }
            target[key] = value;
            return true;
        }
    });

    const toggleLateralMenu = function(){
        if(lateralMenu){
            document.querySelector("#lateral-menu").classList.add("lateral-menu-outanim")
            document.querySelector("#lateral-menu").classList.remove("lateral-menu-enteranim")
            document.body.classList.remove("body-overflow-hidden")
        }else{
            document.querySelector("#lateral-menu").classList.remove("lateral-menu-outanim")
            document.querySelector("#lateral-menu").classList.add("lateral-menu-enteranim")
            document.body.classList.add("body-overflow-hidden")
        }
        lateralMenu = !lateralMenu;
    }

    const toggleMobileMenu = function (e) {
        if (e) {
            document.querySelector("#header").classList.add("element-hide")
            document.querySelector("#header-mobile").classList.remove("element-hide")
        } else {
            document.querySelector("#header").classList.remove("element-hide")
            document.querySelector("#header-mobile").classList.add("element-hide")
        }
    }

    window.onload = () =>{
        windowDimensionsProxy.height = window.innerHeight;
        windowDimensionsProxy.width = window.innerWidth;
    }
</script>

<?php include RESOURCES_ROOT . "/templates/login-modal.php"; ?>
<script>
    const openLogin = function () {
        if (document.querySelector("div#login-modal").classList.contains("show-modal")) {
            document.querySelector("div#login-modal").classList.remove("show-modal")
            document.querySelector("div#login-modal").classList.add("hide-modal")
            document.querySelector("body").classList.remove("body-overflow-hidden")
        } else {
            document.querySelector("div#login-modal").classList.add("show-modal")
            document.querySelector("div#login-modal").classList.remove("hide-modal")
            document.querySelector("body").classList.add("body-overflow-hidden")
        }
    }

    window.onscroll = function (e) {
        var scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document
            .body).scrollTop
        if (scrollTop > 90) {
            document.querySelector("nav#header").classList.add("header-scrolling");
            document.querySelector("nav#header").classList.remove("header-on-top");
        } else {
            document.querySelector("nav#header").classList.remove("header-scrolling");
            document.querySelector("nav#header").classList.add("header-on-top");
        }
    }

    var searchOpen = false;


    //document.querySelector("input#search-input").style.display = "none";
    const toggleSearch = function () {
        searchOpen = !searchOpen;
        if (searchOpen) {
            document.querySelector("input.search-input").classList.add("search-in-anim")
            document.querySelector("input.search-input").classList.remove("search-out-anim")
        } else {

            document.querySelector("input.search-input").classList.remove("search-in-anim")
            document.querySelector("input.search-input").classList.add("search-out-anim")
        }
    }


    const searchInput = document.querySelector(".search-input");
    const searchEvent = function (e) {
        if (e.keyCode === 13) {
            let sValue = searchInput.value.replace(/<.*?>/, "");
            if (sValue !== "" && sValue !== " ")
                window.location.href = './search.php?v=' + sValue;
        }
    }

    const searchEventListener = function (e) {
        if (e) {
            searchInput.addEventListener("keyup", searchEvent)
        } else {
            searchInput.removeEventListener('keyup', searchEvent, false);
        }
    }
</script>