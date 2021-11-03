<?php
    $logado = false;
    $favoritado = false;

    if(isset($_SESSION["loged"])){
        $logado = $_SESSION["loged"];

        $conn = openConnection();

        $stmt = $conn->prepare("select * from favoritados A inner join user B on A.UserId = B.Id where Nickname = (?) and MangaId = (?)");
        $stmt->bind_param("si", $_SESSION["user"], $id);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $favoritado = true;
        }
    }

?>

<a class='manga' onclick="read(<?php echo $id ?>)">
    <?php if($logado){
        if($favoritado){
            echo "<span id='favoritar' onclick='toggleFavorite(this, $id)' data-favoritado='true' class='favoritado'></span>";
        }else{
            echo "<span id='favoritar' onclick='toggleFavorite(this, $id)' data-favoritado='false' class='nao-favoritado'></span>";
        }
    } ?>
    <img src='<?php echo $capa ?>' alt="manga-thumb">
    <p><?php echo $nome ?></p>
</a>

<script>
    async function toggleFavorite(element, id){
        let favoritar ;
        if(element.getAttribute('data-favoritado') == 'true'){
            element.classList.remove('favoritado')
            element.classList.add('nao-favoritado')
            element.setAttribute('data-favoritado', false)
            favoritar = false;
        }else{
            element.classList.add('favoritado')
            element.classList.remove('nao-favoritado')
            element.setAttribute('data-favoritado', true)
            favoritar = true;
        }
        event.stopPropagation()
        try{
            console.log(JSON.stringify({
                        id:id,
                        fav:element.getAttribute('data-value') == 'true'
                    }))
            let res = await fetch('actions/favorite-manga.php', {
                    headers:{
                        "Content-Type": "application/json",
                    },
                    method: "POST",
                    body: JSON.stringify({
                        id:id,
                        fav:favoritar
                    })
                });
        }catch(ex){
            console.log(ex)
        }
    }

    function read(e){
        window.location.href = `manga-info.php?id=${e}`
    }

</script>
