window.onload = ()=>{
   document.getElementById('logoutButton').addEventListener('click', function() {
    console.log('logout');
    window.location.href = '../../../auth/logout';
}); 
}
