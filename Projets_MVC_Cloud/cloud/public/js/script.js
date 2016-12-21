function checkAllBox() {
    $('input[type="checkbox"].checkClass').each(function(){
        $(this).attr('checked', true);
    });
}