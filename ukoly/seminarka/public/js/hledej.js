$(document).ready(function(){
    let containers = $(".input-container");

    containers.click(function(e) {
        e.preventDefault();
        $(containers).addClass("disabled");
        $(containers).find("input").attr("disabled", "disabled");
        $(containers).find("input").val("");
        $(this).removeClass("disabled");
        $(this).find("input").removeAttr("disabled").focus();
    });

});