<?php

    session_start();

    $logado = false;

    if(isset($_SESSION["loged"])){
        $logado = $_SESSION["loged"];
        $user = $_SESSION["user"];
    }


?>

<nav id="header" class="header-on-top">
    <a id="header-title" href="index.php">Manga Online</a>
    <ul>
        <li><a href="most-read.php">Mais lidos</a></li>
        <li>Leitura aleatoria</li>
        <li id="category">Categorias ▼
            <div id="category-dropbox">
                <ul>
                    <?php for($i = 1; $i <= 4; $i++){ 
                    echo '<li><a href="categories.php?category=\'Terror\'">Terror</a></li>';
                } ?>
                </ul>
            </div>
        </li>
        <li id="search-div">
            <button id="search-btn" onclick="toggleSearch()"></button>
            <input type="text" onfocus="searchEventListener(true)" onfocusout="searchEventListener(false)" class="search-input" placeholder="Naruto" />
        </li>
        <?php
            if($logado == true){
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
            }else{
                echo '        
                <li id="login-btn" onclick="openLogin()">
                    
                </li>';
            }
        ?>
    </ul>
</nav>
<div id="login-modal" class="hide-modal" tabindex="0">
    <div id="modal-background-overlay" onclick="closeLoginModal()"></div>
    <div id="modal">
        <form action="actions/login.php" method="post" id="loginFrm">
            <header>
                Login
            </header>
            <input type="text" name="nickname" placeholder="JoooaoXD" />
            <input type="password" name="password" placeholder="********" />
            <small href="#" id="small-criar-conta" onclick="toggleCriarContaInputs()">Ainda não possui conta ? Crie
                uma agora</small>
            <button type="submit" name="submit">Login</button>
        </form>
        <form action="actions/register.php" method="post" id="registerFrm" class="element-hide">
            <header>
                Registro
            </header>
            <input type="text" name="nickname" placeholder="JoooaoXD" />
            <input type="text" name="email" placeholder="JoooaoXD@hotmail.com" />
            <input type="password" name="password" placeholder="********" />
            <input type="password" name="secondPassword" placeholder="********" />
            <small href="#" id="small-login" onclick="toggleCriarContaInputs()" onclick="">Já
                possui conta ? Loge agora</small>
            <button type="submit" name="submit">Registrar</button>
        </form>
    </div>
</div>
<script>
    const closeLoginModal = function () {
        document.querySelector("body").classList.remove("body-overflow-hidden")
        document.querySelector("div#login-modal").classList.remove("show-modal")
        document.querySelector("div#login-modal").classList.add("hide-modal")
    }

    var criarConta = false;

    const toggleCriarContaInputs = function () {
        criarConta = !criarConta;

        if (criarConta) {
            document.querySelector("#loginFrm").classList.add("element-hide")
            document.querySelector("#registerFrm").classList.remove("element-hide")
        } else {
            document.querySelector("#loginFrm").classList.remove("element-hide")
            document.querySelector("#registerFrm").classList.add("element-hide")
        }
    }
</script>
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
    const searchEvent = function(e){
        if(e.keyCode === 13){
            let sValue = searchInput.value.replace(/<.*?>/, "");
            if(sValue !== "" && sValue !== " ")
                window.location.href = './search.php?v='+sValue;
        }
    }

    const searchEventListener = function (e) {
        if(e){
            searchInput.addEventListener("keyup", searchEvent)
        }else{
            searchInput.removeEventListener('keyup', searchEvent, false);
        }
    }

</script>