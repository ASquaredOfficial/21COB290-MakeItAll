module.exports = (date)=>{
    /*Format date from 'Tue Jan 15 2019 16:25:00 GMT+0000 (Greenwich Mean Time)' => 15 Jan 2019, 4:25 pm  */
    return dateN = new Date(date).toLocaleDateString('en-GB', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12	: 'false',
    });
}