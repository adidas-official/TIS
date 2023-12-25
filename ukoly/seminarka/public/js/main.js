$(document).ready(function() {

    // Login page 
    $(".reg-log").click(function (e) { 
        e.preventDefault();
        $(".vyber").toggle();
    });

    // Index tab navigace
    $("nav").find("span").each(function() {
        $(this).click(function() {
            $(this).addClass("active").siblings().removeClass("active");
            $(".karta").removeClass("active");
            let target = $(this).data("target");
            $("#"+target).addClass("active");
        });
    });

    // Pridani zbozi do objednavky
    $(".objednavka tbody tr").each(function () { 
        $(this).click(function(e) {
            e.preventDefault();
            let box = $(this).find("input[type=checkbox]");
            box.prop("checked", !box.prop("checked"));
        });
        
    });
});