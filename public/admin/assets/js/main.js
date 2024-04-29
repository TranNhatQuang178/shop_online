$(document).ready(function (){
    $("input[name='checkall']").click(function() {
        var checked = $(this).is(':checked');
        $("table tbody tr td input:checkbox").prop('checked', checked);
       
    });
    $("input:checkbox").css('cursor', 'pointer');
});