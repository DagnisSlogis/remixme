$(document).ready(function() {
$('a.login-window').click(function() {
    
//Getting the variable's value from a link
    var loginBox = $(this).attr('href');

    //Fade in the Popup
    $(loginBox).slideDown(300);
    
    //Set the center alignment padding + border see css style
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
        'margin-bottom' : -popMargTop,
        'margin-left' : -popMargLeft
    });

    return false;
});

// When clicking on the button close or the mask layer the popup closed
$('a.close').on('click', function() { 
  $('#mask , .login-popup').slideUp(300 , function() {
}); 
return false;
});
});

$(document).ready(function() {
    $('.closeModal').on('click', function() {
        $('.modalDialog div').slideUp(300 , function() {
            $('.modalDialog').removeClass("modalDialog");
        });
    });
    });




//Parāda failu pirms augšupielādē
$(function() {
    $("#uploadFile").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
    $("#headerFile").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function(){ // set image data as background of div
                $("#headerPreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});
$(function() {

    var $sidebar   = $("#sidebarrow"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 40;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });

});

// Iesūtīšanas jqu
$(document).ready(function() {
    $('.subm-window').click(function () {
        var hideThis = $(this).data('id');
        $('.fullinfo[data-id=' + hideThis + ']').slideUp(500, function () {
            $(this).hide();
            $('.subminfo[data-id=' + hideThis + ']').slideDown(500, function () {
                $(this).show();
            });
        });

    $( '.scLink[data-id='+hideThis+']' )
        .keyup(function() {
            var value = $( this ).val();
            if(value) {
                var soundcloud = "<iframe width=\"100%\" height=\"115\" scrolling=\"no\" frameborder=\"no\"src=\"http://w.soundcloud.com/player/?url=" + value + "&auto_play=false&color=e45f56&theme_color=00FF00\"></iframe>";
                $('.scprev[data-id='+hideThis+']').slideDown(200, function () {
                    $(this).show();
                    $(this).html(soundcloud);
                });
            }
            else {
                $('.scprev[data-id='+hideThis+']').slideUp(200, function () {
                    $(this).html("");
                    $(this).hide();
                });
            }

        })
        $('.closesubm[data-id=' + hideThis + ']').click(function () {
                $('.subminfo[data-id=' + hideThis + ']').slideUp(500, function () {
                    $(this).hide();
                });
            $('.fullinfo[data-id=' + hideThis + ']').slideDown(500, function () {
                $(this).show();
            });
        });
    });
});
LineChart = new Chart(ctx).Line(data, options);