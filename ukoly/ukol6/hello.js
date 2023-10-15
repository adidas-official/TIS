document.addEventListener("DOMContentLoaded", function() {

    // alert("Vitejte na mych strankach");
    // alert("Tyto stranky nepouzivaji cookies");
    // alert("Neni zac");

    const datum = new Date();
    const rok = datum.getFullYear();
    const mesic = datum.getMonth() + 1;
    const den = datum.getDate();

    document.getElementById("datum").textContent = "Dnes je " + den + "." + mesic + "." + rok;

    document.getElementById("thumbnail").addEventListener("click", function() {
        window.open("velky.jpg");
    });

});
