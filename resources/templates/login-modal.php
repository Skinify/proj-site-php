
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