module.exports = (date)=>{
    /*Format date from 'Tue Jan 15 2019 16:25:00 GMT+0000 (Greenwich Mean Time)' => 2019-15-01  */
    return dateN = new Date(date).toLocaleDateString('en-CA', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    });
}