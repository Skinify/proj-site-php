

function popAlert(text){
    try{
        var div = document.createElement("div")
        div.classList.add("alert")
        var insideDiv = document.createElement("div")
        insideDiv.innerText = text
        div.appendChild(insideDiv)
        setTimeout(() =>{
            document.body.appendChild(div)
        }, 500)
    }catch(ex){
        console.log(ex)
    }
}