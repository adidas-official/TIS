document.addEventListener("DOMContentLoaded", function() {

    let footer = document.createElement("footer");

    let ul = document.createElement('ul');
    footer.appendChild(ul);
    ul.className = "bullets";

    let li = document.createElement('li');
    ul.appendChild(li);

    let index = document.createElement('a');
    index.setAttribute("href", "../index.html");
    index.textContent = "Zpet";
    li.appendChild(index);


    for (var i = 1; i < 4; i++) {
        let li = document.createElement('li');
        let item = document.createElement('a');
        item.setAttribute("href", "frydryn_ukol4cast" + i + ".html");
        item.textContent = "Cast" + i; 
        ul.appendChild(li);
        li.appendChild(item);
    }

    document.body.appendChild(footer);
});