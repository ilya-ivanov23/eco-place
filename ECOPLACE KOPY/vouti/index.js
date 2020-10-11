function register(){
    event.preventDefault();
    let username = document.getElementById('register-login').value;
    let password = document.getElementById('register-password').value;
    let passwordConfirmation = document.getElementById('register-confrimpassword').value;
    fetch('../php/check.php?action=register', {
        method: 'POST',
        body: JSON.stringify({login: username, password: password, confrimpassword: passwordConfirmation}),
        headers: {
            'Content-Type': 'application/json',
        }
    }).then(response => {
        response.json().then(parsedResponse => {
            alert(parsedResponse);
            if (response.ok){
                //перенаправление:
                window.location.replace('/ECOPLACE KOPY/user/')
            }
            
        });
    });
}

function login(event){
    event.preventDefault();
    let username = document.getElementById('auth-login').value;
    let password = document.getElementById('auth-password').value;
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


function getUserPhoto(){
    fetch('../php/check.php?action=getUserPhoto', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    }).then(response => {
        response.json().then(parsedResponse => {
            console.log(parsedResponse);
            let img = document.createElement('img');
            img.src = parsedResponse.photo;
            document.body.append(img);
        });
    });
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