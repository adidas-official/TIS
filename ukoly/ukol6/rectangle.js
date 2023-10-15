document.addEventListener("DOMContentLoaded", function(){

    var button = document.getElementById("calculate");
    var obsah = document.getElementById("obsah");
    var obvod = document.getElementById("obvod");
    var rectangle = document.getElementById("rect");
    var colors = ["red", "lightblue", "gold", "lightsalmon", "greenyellow"];

    button.addEventListener("click", function(event){

        let a = parseInt(document.getElementById("num1").value); // 4 = 4/400
        let b = parseInt(document.getElementById("num2").value); // 7 = 7/400

        if (a < 1 || b < 0) {
            alert("Zadejte kladna cisla");
            return 0;
        }

        const randomColorIndex = Math.floor(Math.random() * colors.length);

        obsah.textContent = a * b + " px"; 
        obvod.textContent = 2*a + 2*b + " px";

        if (a > b) {
            newA = 400;
            newB = (400 * b) / a;
        } else if (b > a) {
            newB = 400;
            newA = (400 * a) / b;
        } else {
            newA = 400;
            newB = 400;
        }

        rectangle.style.width = newA + "px";
        rectangle.style.height = newB + "px";
        rectangle.style.opacity = 1;
        rectangle.style.backgroundColor = colors[randomColorIndex];
    });

});
