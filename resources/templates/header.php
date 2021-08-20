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


</script>