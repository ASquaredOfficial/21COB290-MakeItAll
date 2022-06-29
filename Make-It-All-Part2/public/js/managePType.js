function addPType() {
    var inputElements = document.getElementById('addPTypeForm').elements
    if(inputElements[0].value == '' || inputElements[1].value == ''){
      alert("Please fill in all necessary fields")
      return
    }
    if (confirm('Are you sure you want to add this problem type?')) {
      // Save it!
      document.getElementById('addPTypeForm').submit();
      console.log('Problem type was saved to the database.');
    } else {
      // Do nothing!
      console.log('Problem type was not saved to the database.');
    }
}

function searchPTypeTable(){
    //Get All words from search Bar
    var searchString = document.getElementById('managePTypeSearchBar').value.toLowerCase();
    var words = searchString.split(' ');
    var sortedWords = words.filter(Boolean);
  
    var pTypeRows = document.getElementsByClassName("type_row");
    var filterOpt = document.getElementById("managePTypeSearchDropdown").value
    console.log(pTypeRows.length)
    console.log(pTypeRows[0])
    if (searchString.trim() == "") {
        //If searchbar empty, return all rows
        for (var i = 0; i < pTypeRows.length; i++) {
          pTypeRows[i].style.display = "table-row";
        }
    } else {
        for (var i = 0; i < pTypeRows.length; i++) {
            pTypeRows[i].style.display = "none";
            var id = pTypeRows[i].id.substring(4);
            var idStr = document.getElementById("pTypeId" + id).innerText.toLowerCase();
            var nameStr = document.getElementById("pTypeName" + id).innerText.toLowerCase();
            var parentNameStr = document.getElementById("pTypeParent" + id).innerText.toLowerCase();
  
            if (filterOpt == "all") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        pTypeRows[i].style.display = "table-row";
                    } if (nameStr.includes(sortedWords[j])) {
                        pTypeRows[i].style.display = "table-row";
                    } if (parentNameStr.includes(sortedWords[j])) {
                        pTypeRows[i].style.display = "table-row";
                    } 
                }
            } else if (filterOpt == "id") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        pTypeRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "name") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (nameStr.includes(sortedWords[j])) {
                        pTypeRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "parentName") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (parentNameStr.includes(sortedWords[j])) {
                        pTypeRows[i].style.display = "table-row";
                        break
                    }
                }
            } 
        }
    }
}
  
function editPTypeSubmit(){
    var inputElements = document.getElementById('editPTypeForm').elements
    var emptyUpdate = true;
    for(var i = 1; i < inputElements.length; i++){
        if(!inputElements[i].value){
        }else{
            emptyUpdate = false;
            break
        }
    }
    if(emptyUpdate){
        alert("Fill in a field")
        return
    }
    if (confirm('Are you sure you want to edit this Problem Type?')) {
        // Save it!
        document.getElementById('editPTypeForm').submit();
        console.log('Problem Type was saved to the database.');
    } else {
        // Do nothing!
        console.log('Problem Type was edited to the database.');
    }
}