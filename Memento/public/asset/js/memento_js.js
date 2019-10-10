$(document).ready(function() {

    /**
     * Afficher/Cacher flashBag si rempli
     */
    if($('.textSucces').length >= 1){
        $("#messageSuccess").show("slow");
        setTimeout(function() {
            $("#messageSuccess").hide(1000);
            }, 6000);
    }
    if($('.textError').length >= 1){
        $("#messageError").show("slow");
        setTimeout(function() {
            $("#messageError").hide(1000);
            }, 6000);
    }

});