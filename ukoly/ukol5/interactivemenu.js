document.addEventListener("DOMContentLoaded", function() {

    let menu_items = document.querySelectorAll('.menu a');

    menu_items.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            let target = link.getAttribute('data-target');
            
            // ostatni zmizi
            let others = document.querySelectorAll('.col:nth-child(3) div');
            others.forEach(function(div){
                div.style.display = 'none';
            });

            // objevi se jen jeden
            document.getElementById(target).style.display = 'block';
        });
    });
});