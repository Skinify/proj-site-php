<div id="login-modal" class="hide-modal" tabindex="0">
    <div id="modal-background-overlay" onclick="closeLoginModal()"></div>
    <div id="modal">
        <header>
            Login
        </header>
        <div>
            <input type="text" placeholder="JoooaoXD" />
            <input type="text" placeholder="JoooaoXD@hotmail.com" class="criar-conta-input element-hide" />
            <input type="text" placeholder="********" class="criar-conta-input element-hide" />
            <input type="text" placeholder="********" />
            <small href="#" id="small-criar-conta" onclick="toggleCriarContaInputs()">Ainda não possui conta ? Crie
                uma agora</small>
            <small href="#" id="small-login" class="element-hide" onclick="toggleCriarContaInputs()" onclick="">Já
                possui conta ? Loge agora</small>
            <button>Login</button>
        </div>
    </div>
</div>
<script>
    const closeLoginModal = function () {
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

    const toggleCriarContaInputs = function () {
        criarConta = !criarConta;

        if (criarConta) {
            document.querySelectorAll(".criar-conta-input").forEach(x => x.classList.remove("element-hide"))
            document.querySelector("#small-criar-conta").classList.add("element-hide")
            document.querySelector("#small-login").classList.remove("element-hide")
        } else {
            document.querySelectorAll(".criar-conta-input").forEach(x => x.classList.add("element-hide"))
            document.querySelector("#small-criar-conta").classList.remove("element-hide")
            document.querySelector("#small-login").classList.add("element-hide")
        }
    }
</script>