$(document).ready(function(){
    var city = "2";
    console.log('click');
    $("#more").on("click", function (e) {
        $("#more").before("<input type='text' placeholder='Ville' name='city"+city +"'" +
            "class='form-control'>");
        city += 1;
    });

});