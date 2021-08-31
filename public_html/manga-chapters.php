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
                        //var_dump($array);
                    }
                }
            }


        ?>


    <form class="default-form" method="post" enctype="multipart/form-data"
        onSubmit="return false;">
        <div>
            <label> Capitulo </label>
            <div id="chapter-div">
                <select onChange="selectChapter(this)">
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
            <input id="titulo" name="titulo" type="text" value='<?php echo $r2?>'>
            <label for="desc">Descrição</label>
            <textarea id="desc" name="desc"><?php echo $r4?></textarea>
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

        const selectChapter = function(e){
            console.log(e.value)
            //REQUISIÇÃO PARA BUSCAR INFO DO CAPITULO E PAGINAS
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

        const saveChapter = function () {
            let request = new XMLHttpRequest();

            let allPages = []
            document.querySelectorAll(".page-img").forEach(x => allPages.push(x.src))

            request.open("POST", 'actions/handle-pages.php', false);
            request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

            let payload = {
                data:{
                    mangaId:document.querySelector("#manga-id").value,
                    capituloId:document.querySelector("select").value,
                    title:document.querySelector("#titulo").value,
                    desc:document.querySelector("#desc").value,
                    allPages
                }
            }
            request.send(JSON.stringify(payload));

            request.onreadystatechange = function (e) {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    console.log(e)
                }
            }
        }
    </script>
</body>

</html>