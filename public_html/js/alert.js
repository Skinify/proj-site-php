

function popAlert(text){
    try{
        console.log(text)
        var div = document.createElement("div")
        div.id = "alert"
        div.classList.add("alert")
        var insideDiv = document.createElement("div")
        insideDiv.innerText = text
        div.appendChild(insideDiv)
        setTimeout(() =>{
            if(document.querySelectorAll("#alert").length == 0)
                document.body.appendChild(div)
        }, 1)
    }catch(ex){
        console.log(ex)
    }
}