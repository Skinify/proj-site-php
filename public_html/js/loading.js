const toggleLoading = function (e){
    if(e){
        document.querySelector("#loading").classList.remove("display-none")
    }else{
        document.querySelector("#loading").classList.add("display-none")
    }
};