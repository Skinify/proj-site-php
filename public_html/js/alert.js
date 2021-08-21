function popAlert(text){
    var div = document.createElement("div")
    div.classList.add("alert")
    var insideDiv = document.createElement("div")
    insideDiv.innerText = text
    div.appendChild(insideDiv)
    document.body.appendChild(div)
}