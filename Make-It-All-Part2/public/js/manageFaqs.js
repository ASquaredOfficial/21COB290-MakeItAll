function addFAQs(){
    var inputElements = document.getElementById('addFaqsForm').elements
    if(inputElements[0].value == ''){
      alert("Please fill in all necessary fields")
      return
    }
    if (confirm('Are you sure you want to add this FAQ?')) {
      // Save it!
      document.getElementById('addFaqsForm').submit();
      console.log('FAQ was saved to the database.');
    } else {
      // Do nothing!
      console.log('FAQ was not saved to the database.');
    }
}

function searchFAQsTable(){
    //Get All words from search Bar
    var searchString = document.getElementById('manageFaqsSearchBar').value.toLowerCase();
    var words = searchString.split(' ');
    var sortedWords = words.filter(Boolean);
  
    var faqRows = document.getElementsByClassName("faqs_row");
    var filterOpt = document.getElementById("manageFaqsSearchDropdown").value
    if (searchString.trim() == "") {
        //If searchbar empty, return all rows
        for (var i = 0; i < faqRows.length; i++) {
          faqRows[i].style.display = "table-row";
        }
    } else {
        for (var i = 0; i < faqRows.length; i++) {
          faqRows[i].style.display = "none";
            var id = faqRows[i].id.substring(4);
            var idStr = document.getElementById("faqId" + id).innerText.toLowerCase();
            var questionStr = document.getElementById("faqQuestion" + id).innerText.toLowerCase();
            var answerStr = document.getElementById("faqAnswer" + id).innerText.toLowerCase();
            var ptypeStr = document.getElementById("faqPType" + id).innerText.toLowerCase();
  
            if (filterOpt == "all") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        faqRows[i].style.display = "table-row";
                    } if (questionStr.includes(sortedWords[j])) {
                        faqRows[i].style.display = "table-row";
                    } if (answerStr.includes(sortedWords[j])) {
                      faqRows[i].style.display = "table-row";
                    } if (ptypeStr.includes(sortedWords[j])) {
                      faqRows[i].style.display = "table-row";
                    } 
                }
            } else if (filterOpt == "id") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (idStr.includes(sortedWords[j])) {
                        faqRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "question") {
                for (var j = 0; j < sortedWords.length; j++) {
                    if (questionStr.includes(sortedWords[j])) {
                        faqRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "answer") {
              for (var j = 0; j < sortedWords.length; j++) {
                  if (answerStr.includes(sortedWords[j])) {
                    faqRows[i].style.display = "table-row";
                      break
                  }
              }
          } else if (filterOpt == "problemType") {
            for (var j = 0; j < sortedWords.length; j++) {
                if (ptypeStr.includes(sortedWords[j])) {
                    faqRows[i].style.display = "table-row";
                    break
                }
            }
        } 
        }
    }
}  

function editFaqsSubmit(){
    var inputElements = document.getElementById('editFaqsForm').elements
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
    if (confirm('Are you sure you want to edit this FAQ?')) {
        // Save it!
        document.getElementById('editFaqsForm').submit();
        console.log('FAQ was saved to the database.');
    } else {
        // Do nothing!
        console.log('FAQ was edited to the database.');
    }
}