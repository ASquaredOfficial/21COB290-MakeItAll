module.exports = (dateInput)=>{
    /*Calculate the no. of days between a short date input (in then form )and date today*/
    var dateInput = new Date(dateInput);
	var dateNow = new Date();
    var Difference_In_Time = dateNow.getTime() - dateInput.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    return Math.round(Difference_In_Days)
}