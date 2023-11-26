document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("form_da_validare");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        var nome = document.getElementById("nome");
        var cognome = document.getElementById("cognome");
        var email = document.getElementById("email");
        var numero = document.getElementById("numero");
        var oggetto = document.getElementById("oggetto");
        var messaggio = document.getElementById("messaggio");

        // Rimuovi eventuali messaggi di errore esistenti
        resetAllErrors();

        // Validazione lato client
        var errors = [];

        if (!isValid(nome.value.trim(), 2, 25)) {
            errors.push("Il campo Nome deve contenere tra 2 e 25 caratteri.");
            showError(nome, errors[errors.length - 1]);
        }

        if (!isValid(cognome.value.trim(), 2, 25)) {
            errors.push("Il campo Cognome deve contenere tra 2 e 25 caratteri.");
            showError(cognome, errors[errors.length - 1]);
        }

        if (!isValidEmail(email.value.trim())) {
            errors.push("Inserisci un indirizzo email valido (lunghezza tra 10 e 40 caratteri).");
            showError(email, errors[errors.length - 1]);
        }

        if (!isValidNumber(numero.value.trim())) {
            errors.push("Il campo Numero deve contenere un numero valido.");
            showError(numero, errors[errors.length - 1]);
        }

        if (!isValid(oggetto.value.trim(), 5, 50)) {
            errors.push("Il campo Oggetto deve contenere tra 5 e 50 caratteri.");
            showError(oggetto, errors[errors.length - 1]);
        }

        if (!isValid(messaggio.value.trim(), 5, 500)) {
            errors.push("Il campo Messaggio deve contenere tra 5 e 500 caratteri.");
            showError(messaggio, errors[errors.length - 1]);
        }

        // Invia il modulo solo se non ci sono errori
        if (errors.length === 0) {
            formSubmit();
        }
    });
});

function isValid(value, min, max) {
    return value !== "" && value.length >= min && value.length <= max;
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidNumber(value) {
    return !isNaN(value);
}

function showError(input, message) {
    var parent = input.parentNode;

    // Rimuovi eventuali messaggi di errore esistenti
    resetError(input);

    // Aggiungi il messaggio di errore alla label
    var label = parent.querySelector("label");
    label.innerHTML += '<span class="error-message">' + message + '</span>';
}

function resetError(input) {
    var parent = input.parentNode;
    var errorSpans = parent.querySelectorAll("error-message");
    for (var i = 0; i < errorSpans.length; i++) {
        parent.removeChild(errorSpans[i]);
    }
}

function resetAllErrors() {
    var errorSpans = document.querySelectorAll(".error-message");
    errorSpans.forEach(function (errorSpan) {
        if (errorSpan.parentNode) {
            errorSpan.parentNode.removeChild(errorSpan);
        }
    });
}

function formSubmit() {
    var form = document.getElementById("form_da_validare");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", form.action, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Nascondi il form
            document.getElementById("form_da_validare").style.display = "none";
            // Mostra un messaggio di successo al suo posto
            var msgContainer = document.getElementById("conferma-msg");
            msgContainer.textContent = "Grazie per avermi contattato, ti risponderò entro 24 ore!";
            msgContainer.style.display = "block";
        }
    };

    xhr.onerror = function () {
        // Gestisci eventuali errori
        alert("Errore di connessione durante l'invio del form. Riprova");
    };

    // Invia i dati del form
    var formData = new FormData(form);
    xhr.send(new URLSearchParams(formData));
}


