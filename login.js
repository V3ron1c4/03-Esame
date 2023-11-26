function validateLoginForm(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var errorsContainer = document.querySelector('.errors-container');
    errorsContainer.innerHTML = ''; // Pulisce i messaggi di errore precedenti

    if (username === '' || password === '') {
        displayError('Compila entrambi i campi.');
        return false;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Il server ha risposto con successo
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Reindirizza l'utente alla pagina area_riservata.php
                    window.location.href = 'area_riservata.php';
                } else {
                    // Mostra gli errori restituiti dal server
                    displayServerErrors(response.errors);
                }
            } else {
                // Si è verificato un errore nella richiesta al server
                console.error('Errore nella richiesta al server.');
            }
        }
    };

    // Invia i dati del modulo al server
    xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password));

    return true;
}

function displayError(message) {
    var errorsContainer = document.querySelector('.errors-container');
    var errorElement = document.createElement('div');
    errorElement.classList.add('error');
    errorElement.textContent = message;
    errorsContainer.appendChild(errorElement);
}

function displayServerErrors(errors) {
    var errorsContainer = document.querySelector('.errors-container');
    if (errors.length > 0) {
        errors.forEach(function (error) {
            var errorElement = document.createElement('div');
            errorElement.classList.add('error');
            errorElement.textContent = error;
            errorsContainer.appendChild(errorElement);
        });
    }
}