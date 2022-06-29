function addHardware(){
    var inputElements = document.getElementById('addHardwareForm').elements
    if(inputElements[0].value == ''){
      alert("Please fill in all necessary fields")
      return
    }
    if (confirm('Are you sure you want to add this hardware?')) {
      // Save it!
      document.getElementById('addHardwareForm').submit();
      console.log('Hardware was saved to the database.');
    } else {
      // Do nothing!
      console.log('Hardware was not saved to the database.');
    }
}

function searchHardwareTable(){
    //Get All words from search Bar
    var searchString = document.getElementById('manageHardwareSearchBar').value.toLowerCase();
    var words = searchString.split(' ');
    var sortedWords = words.filter(Boolean);
  
    var hardwareRows = document.getElementsByClassName("hard_row");
    var filterOpt = document.getElementById("manageHardwareSearchDropdown").value
    if (searchString.trim() == "") {
        //If searchbar empty, return all rows
        for (var i = 0; i < hardwareRows.length; i++) {
          hardwareRows[i].style.display = "table-row";
        }
    } else {
        for (var i = 0; i < hardwareRows.length; i++) {
            hardwareRows[i].style.display = "none";
            var id = hardwareRows[i].id.substring(4);
            var idStr = document.getElementById("hardwareId" + id).innerText.toLowerCase();
            var nameStr = document.getElementById("hardwareName" + id).innerText.toLowerCase();
  
            if (filterOpt == "all") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        hardwareRows[i].style.display = "table-row";
                    } if (nameStr.includes(sortedWords[j])) {
                        hardwareRows[i].style.display = "table-row";
                    }
                }
            } else if (filterOpt == "id") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        hardwareRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "name") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (nameStr.includes(sortedWords[j])) {
                        hardwareRows[i].style.display = "table-row";
                        break
                    }
                }
            } 
        }
    }
}

function editHardwareSubmit(){
    var inputElements = document.getElementById('editHardForm').elements
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
    if (confirm('Are you sure you want to edit this Hardware?')) {
        // Save it!
        document.getElementById('editHardForm').submit();
        console.log('Hardware was saved to the database.');
    } else {
        // Do nothing!
        console.log('Hardware was edited to the database.');
    }
}
  