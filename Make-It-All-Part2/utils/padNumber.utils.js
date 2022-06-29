module.exports = (number, length) =>{
    number = number.toString();
    while (number.length < length) {
        number = "0" + number;
    }
    return number;
}