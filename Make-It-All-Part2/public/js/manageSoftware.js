function addSoftware() {
    var inputElements = document.getElementById('addSoftwareForm').elements
    if(inputElements[0].value == ''){
      alert("Please fill in all necessary fields")
      return
    }
    if (confirm('Are you sure you want to add this software?')) {
      // Save it!
      document.getElementById('addSoftwareForm').submit();
      console.log('Software was saved to the database.');
    } else {
      // Do nothing!
      console.log('Software was not saved to the database.');
    }
}


function searchSoftwareTable(){
    //Get All words from search Bar
    var searchString = document.getElementById('manageSoftwareSearchBar').value.toLowerCase();
    var words = searchString.split(' ');
    var sortedWords = words.filter(Boolean);
  
    var softwareRows = document.getElementsByClassName("soft_row");
    var filterOpt = document.getElementById("manageSoftwareSearchDropdown").value
    if (searchString.trim() == "") {
        //If searchbar empty, return all rows
        for (var i = 0; i < softwareRows.length; i++) {
          softwareRows[i].style.display = "table-row";
        }
    } else {
        for (var i = 0; i < softwareRows.length; i++) {
            softwareRows[i].style.display = "none";
            var id = softwareRows[i].id.substring(4);
            var idStr = document.getElementById("softwareId" + id).innerText.toLowerCase();
            var nameStr = document.getElementById("softwareName" + id).innerText.toLowerCase();
  
            if (filterOpt == "all") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        softwareRows[i].style.display = "table-row";
                    } if (nameStr.includes(sortedWords[j])) {
                        softwareRows[i].style.display = "table-row";
                    }
                }
            } else if (filterOpt == "id") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        softwareRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "name") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (nameStr.includes(sortedWords[j])) {
                        softwareRows[i].style.display = "table-row";
                        break
                    }
                }
            } 
        }
    }
  }
  
  function editSoftwareSubmit(){
    var inputElements = document.getElementById('editSoftForm').elements
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
    if (confirm('Are you sure you want to edit this Software?')) {
        // Save it!
        document.getElementById('editSoftForm').submit();
        console.log('Software was saved to the database.');
    } else {
        // Do nothing!
        console.log('Software was edited to the database.');
    }
}