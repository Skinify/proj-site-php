<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/src/css/comum.css" type="text/css">
    <link rel="stylesheet" href="/src/css/estilo.css" type="text/css">
    <link rel="stylesheet" href="/src/css/notchs.css" type="text/css">
    <title>Manga Online</title>
</head>
<body>
    <nav id="header" class="header-on-top">
        <a id="header-title">Manga Online</a>
        <ul>
            <li>Mais lidos</li>
            <li>Leitura aleatoria</li>
            <li id="category">Categorias ▼
                <div id="category-dropbox">
                    <ul>
                        <li>Terror</li>
                        <li>asdasdasdasd</li>
                        <li>Terror</li>
                        <li>Terror</li>
                    </ul>
                </div>
            </li>
            <li id="search-div">
                <button id="search-btn" onclick="toggleSearch()"></button>
                <input type="text" class="search-input" placeholder="Naruto"/>  
            </li>
            <li id="login-btn" onclick="openLogin()">
                  
            </li>
        </ul>
    </nav>
    <div id="splash-screen-background" style="filter:blur(0px) brightness(0.1)" class="full-splash"></div>
    <div id="manga-paper"></div>
    <div id="manga-controls">
        <div><button>-</button> <a>Luminosidade</a> <button>+</button> </div>
        <div><button><</button> <a>Pagina</a> <button>></button></div>
        <div><button><</button> <a>Capitulo</a> <button>></button></div>
    </div>

    <div id="login-modal" class="hide-modal" tabindex="0">
        <div id="modal-background-overlay" onclick="closeLoginModal()"></div>
        <div id="modal">
            <header>
                Login
            </header>
            <div>
                <input type="text" placeholder="JoooaoXD"/>
                <input type="text" placeholder="JoooaoXD@hotmail.com" class="criar-conta-input element-hide"/>
                <input type="text" placeholder="********" class="criar-conta-input element-hide"/>
                <input type="text" placeholder="********"/>
                <small href="#" id="small-criar-conta" onclick="toggleCriarContaInputs()">Ainda não possui conta ? Crie uma agora</small>
                <small href="#" id="small-login" class="element-hide" onclick="toggleCriarContaInputs()" onclick="">Já possui conta ? Loge agora</small>
                <button>Login</button>
            </div>
        </div>
    </div>
    <script>
        window.onscroll = function(e){
            var scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop
            if(scrollTop > 90){
                document.querySelector("nav#header").classList.add("header-scrolling");
                document.querySelector("nav#header").classList.remove("header-on-top");
            }else{
                document.querySelector("nav#header").classList.remove("header-scrolling");
                document.querySelector("nav#header").classList.add("header-on-top");
            }
        }

        var searchOpen = false;


        //document.querySelector("input#search-input").style.display = "none";
        const toggleSearch = function (){
            searchOpen = !searchOpen;
            if(searchOpen){
                document.querySelector("input.search-input").classList.add("search-in-anim")
                document.querySelector("input.search-input").classList.remove("search-out-anim")
            }else{

                document.querySelector("input.search-input").classList.remove("search-in-anim")
                document.querySelector("input.search-input").classList.add("search-out-anim")
            }
        }

        const openLogin = function(){
            if(document.querySelector("div#login-modal").classList.contains("show-modal")){
                document.querySelector("div#login-modal").classList.remove("show-modal")
                document.querySelector("div#login-modal").classList.add("hide-modal")
                document.querySelector("body").classList.remove("body-overflow-hidden")
            }else{
                document.querySelector("div#login-modal").classList.add("show-modal")
                document.querySelector("div#login-modal").classList.remove("hide-modal")
                document.querySelector("body").classList.add("body-overflow-hidden")
            }
        }

        const closeLoginModal = function (){
            document.querySelector("body").classList.remove("body-overflow-hidden")
            console.log("Slvasd")
            document.querySelector("div#login-modal").classList.remove("show-modal")
            document.querySelector("div#login-modal").classList.add("hide-modal")

            criarConta = false;

            document.querySelectorAll(".criar-conta-input").forEach(x => x.classList.add("element-hide"))
            document.querySelector("#small-criar-conta").classList.remove("element-hide")
            document.querySelector("#small-login").classList.add("element-hide")
        }
        
        var criarConta = false;
        
        const toggleCriarContaInputs = function(){
            criarConta = !criarConta;

            if(criarConta){
                document.querySelectorAll(".criar-conta-input").forEach(x => x.classList.remove("element-hide"))
                document.querySelector("#small-criar-conta").classList.add("element-hide")
                document.querySelector("#small-login").classList.remove("element-hide")
            }else{
                document.querySelectorAll(".criar-conta-input").forEach(x => x.classList.add("element-hide"))
                document.querySelector("#small-criar-conta").classList.remove("element-hide")
                document.querySelector("#small-login").classList.add("element-hide")
            }
            
        }


    </script>
</body>
</html>