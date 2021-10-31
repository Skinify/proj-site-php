<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");

            

            $id = 0;
            $array = [];
            $r1 = "";
            $queries = array();

            parse_str($_SERVER['QUERY_STRING'], $queries);
            if(array_key_exists('id', $queries)){
                $id = clean($queries['id']);
                $conn = openConnection();
                $stmt = $conn->prepare("select `Id` from capitulo where `IdManga` = (?)");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($r1);
                if($stmt->num_rows == 0){
                    echo "<script> popAlert('O manga não possui capitulos ainda'); </script>";
                }else{
                    while($stmt->fetch()){
                        array_push($array, $r1);
                    }
                }
            }


        ?>


    <form class="default-form" method="post" enctype="multipart/form-data"
        onSubmit="return false;">
        <div>
            <label> Capitulo </label>
            <div id="chapter-div">
                <select class="default-select" onChange="selectChapter(this)">
                    <?php 
                        $i = 1;
                        foreach ($array as $value){
                            echo "<option value='$value'> $i </option>";
                            $i++;
                        }
                    ?>
                </select>
                <button onClick="addChapter(true)">+</button>
                <button onClick="addChapter(false)">-</button>
            </div>
            <input type="hidden" id="manga-id" value="<?php echo $id;?>"/>
            <label for="titulo">Titulo</label>
            <input id="titulo" name="titulo" type="text">
            <label for="desc">Descrição</label>
            <textarea id="desc" name="desc"></textarea>
            <button type="button" onClick="saveChapter(this)">Salvar paginas</button>
        </div>
        <div>
            <label style="text-align:center" for="file-input">Paginas</label>
            <input type="hidden" id="capa-base" name="capa-base"
                value="<?php echo isset($editing) && $editing == true ? $r5 : 'vazio'?>">
            <div id="pages-container">
            </div>

            <input type="file" name="capa" id="file-input" accept="image/png, image/jpeg"
                onChange="changeImage(this.files)" multiple />
        </div>
    </form>
    <script>
        let paginas = 0;

        const removePageAndReorder = function (e) {
            e.parentElement.remove()
            let it = 1;
            for (element of document.querySelectorAll(".page-wrapper > .page-number")) {
                element.innerText = it;
                it++;
            }

        }

        const changeImage = async function (e) {
            for (var file of e) {
                paginas++;
                var div = document.createElement("div")
                div.classList.add("page-wrapper")
                var a = document.createElement("a");
                a.innerText = paginas;
                a.classList.add("page-number");
                div.appendChild(a)
                var img = document.createElement("img");
                img.classList.add("page-img");
                img.src = await base64Reader(file)
                img.setAttribute("ordem", paginas);
                div.appendChild(img)
                var btn = document.createElement("button")
                btn.type = "button"
                btn.onclick = function () {
                    removePageAndReorder(this)
                };
                btn.innerText = "X"
                div.appendChild(btn)
                document.querySelector("#pages-container").appendChild(div);
            }
        }

        const selectChapter = async function(e){
            toggleLoading(true);
            paginas = 0;
            document.querySelector("#pages-container").innerHTML = "";
            try{
                let res = await fetch('actions/chapters-info.php', {
                    headers:{
                        "Content-Type": "application/json;charset=UTF-8",
                    },
                    method: "POST",
                    body: JSON.stringify({
                        capituloId:e.value,
                    })
                });
                let t = await res.json()
                document.querySelector("#titulo").value = t.data.Titulo
                document.querySelector("#desc").value = t.data.Desc
                for (var img64 of t.data.Pages) {
                    paginas++;
                    var div = document.createElement("div")
                    div.classList.add("page-wrapper")
                    var a = document.createElement("a");
                    a.innerText = paginas;
                    a.classList.add("page-number");
                    div.appendChild(a)
                    var img = document.createElement("img");
                    img.classList.add("page-img");
                    img.src = img64.img
                    img.setAttribute("ordem", paginas);
                    div.appendChild(img)
                    var btn = document.createElement("button")
                    btn.type = "button"
                    btn.onclick = function () {
                        removePageAndReorder(this)
                    };
                    btn.innerText = "X"
                    div.appendChild(btn)
                    document.querySelector("#pages-container").appendChild(div);
                }
            }catch(ex){
                console.log(ex)
            }
            toggleLoading(false);
        }


        const chapterRequest = async function(e){
            try{
                let res = await fetch('actions/handle-chapters.php', {
                    headers:{
                        "Content-Type": "application/json;charset=UTF-8",
                    },
                    method: "POST",
                    body: JSON.stringify({
                        valor:e,
                        manga:document.querySelector("#manga-id").value,
                    })
                });
            }catch(ex){
                console.log(ex)
            }
            refreshChapters()
        }


        const refreshChapters = async function(){
            paginas = 0;
            try{
                let res = await fetch('actions/list-manga-chapters.php', {
                    headers:{
                        "Content-Type": "application/json;charset=UTF-8",
                    },
                    method: "POST",
                    body: JSON.stringify({
                        manga:document.querySelector("#manga-id").value,
                    })
                });
                let t = await res.json()
                document.querySelector("select").innerHTML = "";
                let it = 1;
                t.data.forEach(x => {
                    let option = document.createElement("option")
                    option.innerText = it;
                    option.value = x;
                    it++;
                    document.querySelector("select").appendChild(option);
                })
            }catch(ex){
                console.log(ex)
            }
        }

        const addChapter = function(i){
            paginas = 0;
            if(i == true){
                let option = document.createElement("option")
                if(document.querySelector("option:last-of-type") != null){
                    option.innerText = eval(document.querySelector("option:last-of-type").innerHTML) + 1;
                }else{
                    option.innerText = 1;
                }
                document.querySelector("select").appendChild(option);
                chapterRequest(0)
            }else{
                let currentChap = document.querySelector("select").value;
                if(currentChap !== ""){
                    document.querySelector(`option[value='${currentChap}']`).remove();
                    chapterRequest(currentChap);
                }   
            }

            let currentChap = document.querySelector("select").value;
            if(currentChap !== ""){
                selectChapter(document.querySelector("select"))
            }
        }

        const saveChapter = async function () {
            if(document.querySelector("select").options.length == 0)
                return;
                
            toggleLoading(true);
            try{
                let allPages = []
                document.querySelectorAll(".page-img").forEach(x => allPages.push({
                    img: x.src,
                    ordem: x.getAttribute("ordem")
                }))

                let payload = {
                    data:{
                        mangaId:document.querySelector("#manga-id").value,
                        capituloId:document.querySelector("select").value,
                        title:document.querySelector("#titulo").value,
                        desc:document.querySelector("#desc").value,
                        ordem:document.querySelector("select").options[document.querySelector("select").selectedIndex].text,
                        allPages
                    }
                }

                let res = await fetch('actions/handle-pages.php', {
                    headers:{
                        "Content-Type": "application/json;charset=UTF-8",
                    },
                    method: "POST",
                    body: JSON.stringify(payload)
                });
                popAlert("Sucesso");
            }catch(ex){
                console.log(ex)
            }
            toggleLoading(false);
        }

        if(document.querySelector("select").value !== "")
            selectChapter(document.querySelector("select"))
    </script>
</body>

</html>