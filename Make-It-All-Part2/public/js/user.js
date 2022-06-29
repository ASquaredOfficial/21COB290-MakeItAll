function toggleFAQ(elem){
    var faqID = elem.id
    var faqNo = faqID.replace("faq", "");

    var faqAnswerID = "faqAnswer".concat(faqNo)
    var faqArrowID = "faqArrow".concat(faqNo)
    var faqAnswer = document.getElementById(faqAnswerID);
    var faqArrow = document.getElementById(faqArrowID);
    if (faqAnswer.style.display === 'none'){
        faqAnswer.style.display = 'block';
        faqArrow.innerHTML = '▲';
    } else {
        faqAnswer.style.display = 'none';
        faqArrow.innerHTML = '▼';
    }
}

function faqSearch(){
    var searchString = document.getElementById('faqSearchBar').value.toLowerCase();
    var x = document.getElementsByClassName("faqArea");
    var words = searchString.split(' ')
    var sortedWords = words.filter(Boolean);
    
    if (searchString.trim() == ""){
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "block"
        }
    } else {
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none"
            var firstPartOfId = x[i].id.substring(3, 6)
            var question = document.getElementById("faqQuestion" + firstPartOfId)
            for(var j = 0; j < sortedWords.length; j++){
                var questionString = question.innerText.toLowerCase()
                if(questionString.includes(sortedWords[j])){ 
                    x[i].style.display = "block"
                    break
                }
            }
        }
    }
    

}

function charMax(elem){
    var chars = elem.value;
    var charsLeft = 300 - chars.length
    document.getElementById('charLenSoFar').innerText = charsLeft;
}

function userSearch() {
    //Get All words from search Bar
    var searchString = document.getElementById('userSearchBar').value.toLowerCase();
    var words = searchString.split(' ');
    var sortedWords = words.filter(Boolean);
    
    var ticketRows = document.getElementsByClassName("probRow");
    var filterOpt = document.getElementById("userSearchDropdown").value
    if (searchString.trim() == ""){
        for (var i = 0; i < ticketRows.length; i++) {
            ticketRows[i].style.display = "table-row";
        }
    } else {
        for (var i = 0; i < ticketRows.length; i++) {
            ticketRows[i].style.display = "none";
            var elemID = ticketRows[i].id.substring(4, 8);
            var probIdNumberString = document.getElementById("probIDNo" + elemID).innerText.toLowerCase();
            var empNameString = document.getElementById("probName" + elemID).innerText.toLowerCase();
            var descriptionString = document.getElementById("probDesc" + elemID).innerText.toLowerCase();
            var probTypeString = document.getElementById("probType" + elemID).innerText.toLowerCase();
            var hardwareString = document.getElementById("probHard" + elemID).innerText.toLowerCase();
            var softwareString = document.getElementById("probSoft" + elemID).innerText.toLowerCase();
            var probDateString = document.getElementById("probDate" + elemID).innerText.toLowerCase();
            var probStatusString = document.getElementById("probStat" + elemID).innerText.toLowerCase();
            
            if (filterOpt == "all"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(probIdNumberString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(empNameString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(descriptionString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(probTypeString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(hardwareString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(softwareString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(probDateString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    } if(probStatusString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                    }
                }
            } else if (filterOpt == "pID"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(probIdNumberString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "empName"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(empNameString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "probDesc"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(descriptionString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "probType"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(probTypeString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "probHard"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(hardwareString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "probSoft"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(softwareString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "probDate"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(probDateString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } else if (filterOpt == "probStat"){
                for(var j = 0; j < sortedWords.length; j++){
                    if(probStatusString.includes(sortedWords[j])){ 
                        ticketRows[i].style.display = "table-row";
                        break
                    }
                }
            } 
                
        }
    }
}

document.getElementById('userSearchBar').addEventListener('keydown', function (event) {
    if (event.keyCode === 13 && event.target.nodeName === 'INPUT') {
        userSearch()
        event.preventDefault();
    }
});

function table_sort() {
    const styleSheet = document.createElement('style')
    styleSheet.innerHTML = `
          .order-inactive span {
              visibility:hidden;
          }
          .order-inactive:hover span {
              visibility:visible;
          }
          .order-active span {
              visibility: visible;
          }
      `
    document.head.appendChild(styleSheet)
  
    document.querySelectorAll('th.order').forEach(th_elem => {
      let asc = true
      const span_elem = document.createElement('span')
      span_elem.style = "font-size:0.8rem; margin-left:0.5rem"
      span_elem.innerHTML = "▼"
      th_elem.appendChild(span_elem)
      th_elem.classList.add('order-inactive')
  
      const index = Array.from(th_elem.parentNode.children).indexOf(th_elem)
      th_elem.addEventListener('click', (e) => {
        document.querySelectorAll('th.order').forEach(elem => {
          elem.classList.remove('order-active')
          elem.classList.add('order-inactive')
        })
        th_elem.classList.remove('order-inactive')
        th_elem.classList.add('order-active')
  
        if (!asc) {
          th_elem.querySelector('span').innerHTML = '▲'
        } else {
          th_elem.querySelector('span').innerHTML = '▼'
        }
        const arr = Array.from(th_elem.closest("table").querySelectorAll('tbody tr'))
        arr.sort((a, b) => {
          const a_val = a.children[index].innerText
          const b_val = b.children[index].innerText
          return (asc) ? a_val.localeCompare(b_val) : b_val.localeCompare(a_val)
        })
        arr.forEach(elem => {
          th_elem.closest("table").querySelector("tbody").appendChild(elem)
        })
        asc = !asc
      })
    })
}
table_sort()

function showFilters() {
    document.getElementById("mainLogPage").style.pointerEvents = "none";
    document.getElementById("searchGroup").style.pointerEvents = "none";
    document.getElementById("logTable").style.pointerEvents = "none";
    document.getElementById('mainLogPage').setAttribute("style","opacity:0.5; -moz-opacity:0.5; filter:alpha(opacity=50)");
     document.getElementById("footer").style.pointerEvents = "none";
    document.getElementById('footer').setAttribute("style","opacity:0.5; -moz-opacity:0.5; filter:alpha(opacity=50)");
   
    document.getElementById('filterOptions').style.display = 'block';    
} function hideFilters(){
    document.getElementById("mainLogPage").style.pointerEvents = "auto";
    document.getElementById("searchGroup").style.pointerEvents = "auto";
    document.getElementById("logTable").style.pointerEvents = "auto";
    document.getElementById('mainLogPage').setAttribute("style","opacity:1; -moz-opacity:1; filter:alpha(opacity=100)");
    document.getElementById("footer").style.pointerEvents = "auto";
    document.getElementById('footer').setAttribute("style","opacity:1; -moz-opacity:1; filter:alpha(opacity=100)");
    
    document.getElementById('filterOptions').style.display = 'none';
} function clearFilters(){
    hideFilters();
    var inputElements = document.getElementById('filterForm').elements
    inputElements['closedBox'].checked = false;
    inputElements['lowBox'].checked = false;
    inputElements['mediumBox'].checked = false;
    inputElements['highBox'].checked = false;

    inputElements['filterDate1'].value = '';
    inputElements['filterDate2'].value = '';

    inputElements['openBox'].checked = false;
    inputElements['pendingBox'].checked = false;
    inputElements['solvedBox'].checked = false;
    
    document.getElementById('filterForm').submit();
} function submitFilters(){
    var inputElements = document.getElementById('filterForm').elements
    
    //Error handling: Ensure no contradictory options are picked
    if (inputElements['closedBox'].checked && (inputElements['openBox'].checked || inputElements['pendingBox'].checked)) {
        alert("Tickets cannot have a 'closed' Priority and ('open' or 'pending') Status");
        inputElements['closedBox'].checked = false;
        inputElements['openBox'].checked = false;
        inputElements['pendingBox'].checked = false;
        return;
    }
    if (inputElements['solvedBox'].checked && (inputElements['lowBox'].checked || inputElements['mediumBox'].checked || inputElements['highBox'].checked)) {
        alert("Solved tickets cannot have a low or medium or high priority");
        inputElements['solvedBox'].checked = false;
        inputElements['lowBox'].checked = false;
        inputElements['mediumBox'].checked = false;
        inputElements['highBox'].checked = false;
        return;
    }

    //Submit form if at least one input filled
    var allEmpty = true;
    for (var i = 0; i < inputElements.length; i++ ) {
        if (inputElements[i].checked || inputElements[i].value.includes("-")) {
            allEmpty = false;
            break
        }

    } 
    if (!allEmpty){
        document.getElementById('filterForm').submit();
    } else {
        alert('No fields can be empty')
        return
    }
}