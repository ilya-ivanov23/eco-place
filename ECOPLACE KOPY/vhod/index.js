function login(event){
    event.preventDefault();
    let username = document.getElementById('auth-login').value;
    let password = document.getElementById('auth-password').value;
    if (username && password){
        fetch('../php/check.php?action=login', {
            method: 'POST',
            body: JSON.stringify({login: username, password: password}),
            headers: {
                'Content-Type': 'application/json',
            }
        }).then(response => {
            response.json().then(parsedResponse => {
                // alert(parsedResponse);
                // getUserPhoto();
                if (response.ok){
                    //перенаправление:
                    window.location.replace('/ECOPLACE KOPY/user/')
                }else{
                    alert(parsedResponse);
                }
            });
            
        });
       
    }
    else {alert("введите данные")}
  
}
function getUserProfile(){
    fetch('../php/cheeck.php?Action=getUserProfile', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    }).then(response => {
        response.json().then(parsedResponse => {
            console.log(parsedResponse);
           
        });
    });
}