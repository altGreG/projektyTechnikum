document.querySelector(".nav-btn").addEventListener("click", show);
var iloscKlikniec = 1;
// funkcja zapobiega znikaniu menu
window.addEventListener('resize', function(event) {
    if (window.innerWidth > 900) {
        let lista = document.querySelector(".nav");
            lista.style.display = "flex";
    }
}, true);

// funkcja odpowiada za mechanizm rozwijania i zwijania menu gdy ekran ma mniej niż 900px szerokości
function show(){
    iloscKlikniec++;
    if (iloscKlikniec%2 == 0) {
        let lista = document.querySelector(".nav");
        lista.style.display = "flex";
    }else{
        let lista = document.querySelector(".nav");
        lista.style.display = "none";
    }
}