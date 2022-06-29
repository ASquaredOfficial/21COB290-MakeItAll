module.exports = (string) =>{
    if (string.includes(" ")){
        var strings = string.split(" ");
        var outputString = "";
        for (var i = 0; i <strings.length; i++){
            let newWord = strings[i].charAt(0).toUpperCase() + strings[i].slice(1).toLowerCase();
            outputString = outputString +" "+ newWord.trim(" ");
        }
        return outputString.trim(" ");
    }
    else {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }
}