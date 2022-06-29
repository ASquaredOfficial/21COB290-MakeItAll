function handleTransfer(e) {
    var form = document.getElementById("transferContainer");
    var title = document.getElementById("formTitle");
    var logid = document.getElementById("logId");
    console.log(e.dataset)
    logid.value = e.dataset.logid;
    title.innerText = "Transfer ";
    form.style.display = "block";
}

document.getElementById("transferContainer").addEventListener('click', e => {
  if(e.target !== e.currentTarget) console.log("child clicked") 
  else e.target.style.display = "none";
});