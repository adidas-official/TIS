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

    // // Pridani zbozi do objednavky
    // $(".objednavka tbody tr").each(function () { 
    //     $(this).click(function(e) {
    //         e.preventDefault();
    //         $(this).toggleClass("oznacene");
    //         let box = $(this).find("input[type=checkbox]");
    //         let pocet = $(this).find("input[type=number]");
    //         console.log(pocet.val());
    //         box.prop("checked", !box.prop("checked"));
    //     });
        
    // });

    function oznac(row, toggle=true) {

        let box = row.find("input[type=checkbox]");
        if (toggle) {
            box.prop("checked", !box.prop("checked"));
        } else {
            box.prop("checked", true);
        }
    }

    $(".objednavka tbody tr td:not(:first-child):not(:last-child)").each(function () { 
        $(this).click(function(e) {
            e.preventDefault();
            let row = $(this).parent();
            row.toggleClass("oznacene");
            oznac(row);
        });
        
    });

    $(".objednavka tbody tr td:last-child").each(function () { 
        $(this).click(function(e) {
            e.preventDefault();
            let row = $(this).parent();
            row.addClass("oznacene");
            oznac(row, false);
        });
        
    });

    function celkem() {
        let cena_total = 0;

        $('.objednavka tbody tr.oznacene').each(function() {

            let row_cena_selector = $(this).find(".cena").text();
            let pocet = $(this).find("input[type=number]").val();
            let row_cena = row_cena_selector * pocet;

            cena_total += row_cena;

        });

        return cena_total;

    }

    // Zobrazeni cenove kalkulace
    const cena = $('.show_cena');
    $('.objednavka tbody tr').click(function(e) {

        cena_total = celkem();
        cena.html(cena_total);
    });

    $('.objednavka tbody input[type=number]').keyup(function(e) {

        cena_total = celkem();
        cena.html(cena_total);
    });


});