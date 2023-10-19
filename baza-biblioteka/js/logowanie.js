//funkcja umożliwia sprawdzenie hasła, w sensie zmienia kropki w input number na zwyczajne litery i na odwrót
function sprawdzenieHasla() {
    var x = document.getElementById("haslo");
    if (x.type === "password") {
     x.type = "text";
    } else {
    x.type = "password";
    }}