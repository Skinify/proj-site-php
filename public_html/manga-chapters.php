<?php include dirname(__DIR__, 1) . "/resources/templates/base.php";  ?>
<html lang="pt-br">
<?php includeWithVariables("../resources/templates/head.php", array('pageTitle' => 'Mange online'));?>

<body>
    <?php 
            include(RESOURCES_ROOT . "/templates/adm-page.php");
            include(RESOURCES_ROOT . "/templates/header.php");

            

            $editing = false;
            $id = 0;

            $r1 = ""; $r2= ""; $r3 = ""; $r4 = "";
            $queries = array();
            parse_str($_SERVER['QUERY_STRING'], $queries);
            if(array_key_exists('id', $queries)){
                $editing = true;
                $id = clean($queries['id']);
                $conn = openConnection();
                $stmt = $conn->prepare("select * from manga where id = (?)");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($r1,$r2,$r3,$r4,$r5);

                if($stmt->num_rows == 0){
                    $editing = false;
                    echo "<script> popAlert('O manga não existe'); </script>";
                }else{
                    $editing = true;
                    while($stmt->fetch()){}
                }
            }


        ?>


    <form class="default-form" method="post" enctype="multipart/form-data"
        onSubmit="return false;">
        <div>
            <label> Capitulo </label>
            <div id="chapter-div">
                <select>
                    <option value="0">a</option>
                    <option value="1">b</option>
                    <option value="2">c</option>
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

        const addChapter = function(i){

            if(i == true){
                let option = document.createElement("option")
                option.innerText = "1"
                option.value = "1"
                document.querySelector("select").appendChild(option);
            }else{
                let currentChap = document.querySelector("select").value;
                if(currentChap !== "")
                    document.querySelector(`option[value='${currentChap}']`).remove();
            }


            return;

            let request = new XMLHttpRequest();

            let allPages = []
            document.querySelectorAll(".page-img").forEach(x => allPages.push(x.src))

            request.open("POST", 'actions/handle-chapter.php', false);
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