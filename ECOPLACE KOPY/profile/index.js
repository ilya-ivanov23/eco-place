

function getUserProfile(){
    fetch('../php/check.php?action=getUserProfile', {
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