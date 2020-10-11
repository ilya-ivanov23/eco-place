function getUserPhoto(){
    fetch('../ECOPLACE KOPY/user/check.php?action=getUserPhoto', {
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