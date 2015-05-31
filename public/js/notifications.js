
// Atverot notification paneli nolasa katra atribūta id un aizsūta controlierim.

$(document).ready(function() {
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#is_read').click(function() {
        var IsRead =  new Array();
        var i = 0;
        //no data-id nolasa katra notification id
        $('.notificationbox').find('.subject').each(function() {
            IsRead.push($( this ).data('id'));
            i++;
        });
        $.post('/is_read' , { IsRead : IsRead });
    });
});