module.exports = (length) => {
    let chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()";
    let passLength = length;
    let password = "";
    for(let i = 0; i < passLength; i++){
        var randomPos = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomPos, randomPos +1);
    }
    return "password1";
}