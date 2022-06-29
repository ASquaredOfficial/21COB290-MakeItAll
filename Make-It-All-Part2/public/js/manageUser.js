function addUser() { //check if selected employee, nothing is empty, check is selected else, first 4 aren't empty, check if no role selected, then don't do anything.
    var inputElements = document.getElementById('addUserForm').elements
    if(inputElements[3].value == ''){
      alert("Please select a role")
      return
    }else{
      if(inputElements[0].value == '' || inputElements[1].value == '' || inputElements[2].value == ''){
        alert("Please fill in all necessary fields for a " + inputElements[3].value)
        return
      }else if(inputElements[3].value == 'Employee' && (inputElements[4].value == '' || inputElements[5].value == '' || inputElements[6].value == '')){
        alert("Please fill in all necessary field for an Employe")
        return
      }
    }
    if (confirm('Are you sure you want to add this user?')) {
      // Save it!
      document.getElementById('addUserForm').submit();
      console.log('User was saved to the database.');
    } else {
      // Do nothing!
      console.log('User was not saved to the database.');
    }
} 
  
function searchUsersTable(){
    //Get All words from search Bar
    var searchString = document.getElementById('manageUsersSearchBar').value.toLowerCase();
    var words = searchString.split(' ');
    var sortedWords = words.filter(Boolean);

    var userRows = document.getElementsByClassName("user_row");
    var filterOpt = document.getElementById("manageUsersSearchDropdown").value
    console.log(userRows.length)
    console.log(userRows[0])
    if (searchString.trim() == "") {
        //If searchbar empty, return all rows
        for (var i = 0; i < userRows.length; i++) {
          userRows[i].style.display = "table-row";
        }
    } else {
        for (var i = 0; i < userRows.length; i++) {
            userRows[i].style.display = "none";
            var email = userRows[i].id.substring(4);
            var emailStr = document.getElementById("userEmail" + email).innerText.toLowerCase();
            var firstnameStr = document.getElementById("userFName" + email).innerText.toLowerCase();
            var lastnameStr = document.getElementById("userLName" + email).innerText.toLowerCase();
            var roleStr = document.getElementById("userRole" + email).innerText.toLowerCase();
            var departmentStr = document.getElementById("userDept" + email).innerText.toLowerCase();
            var phonenoStr = document.getElementById("userPNo" + email).innerText.toLowerCase();
            var jobtitleStr = document.getElementById("userJTitle" + email).innerText.toLowerCase();

            if (filterOpt == "all") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (emailStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    } if (firstnameStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    } if (lastnameStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    } if (roleStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    } if (departmentStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    } if (phonenoStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    } if (jobtitleStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                    }
                }
            } else if (filterOpt == "email") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (emailStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "firstname") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (firstnameStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "lastname") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (lastnameStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "role") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (roleStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "department") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (departmentStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "phoneno") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (phonenoStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "jobtitle") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (jobtitleStr.includes(sortedWords[j])) {
                        userRows[i].style.display = "table-row";
                        break
                    }
                }
            }
        }
    }
}

function editUserSubmit(){
    var inputElements = document.getElementById('editUserForm').elements
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
    if (confirm('Are you sure you want to edit this user?')) {
      // Save it!
      document.getElementById('editUserForm').submit();
      console.log('User was saved to the database.');
    } else {
      // Do nothing!
      console.log('User was edited to the database.');
    }
}