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
            <input type="text" class="search-input" placeholder="Naruto" />
        </li>
        <li id="login-btn" onclick="openLogin()">
            
        </li>
    </ul>
</nav>
<div id="login-modal" class="hide-modal" tabindex="0">
    <div id="modal-background-overlay" onclick="closeLoginModal()"></div>
    <div id="modal">
        <form action="actions/login.php" method="post" id="loginFrm">
            <header>
                Login
            </header>
            <input type="text" placeholder="JoooaoXD@hotmail.com" />
            <input type="password" placeholder="********" />
            <small href="#" id="small-criar-conta" onclick="toggleCriarContaInputs()">Ainda não possui conta ? Crie
                uma agora</small>
            <button>Login</button>
        </form>
        <form action="actions/register.php" method="post" id="registerFrm" class="element-hide">
            <header>
                Registro
            </header>
            <input type="text" placeholder="JoooaoXD" />
            <input type="text" placeholder="JoooaoXD@hotmail.com" />
            <input type="password" placeholder="********" />
            <input type="password" placeholder="********" />
            <small href="#" id="small-login" onclick="toggleCriarContaInputs()" onclick="">Já
                possui conta ? Loge agora</small>
            <button>Registrar</button>
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
</script>