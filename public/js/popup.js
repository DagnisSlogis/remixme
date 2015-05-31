
//Atver iznirstošo paneli
$(document).ready(function() {
    $('a.login-window').click(function() {
        var loginBox = $(this).attr('href');
        $(loginBox).slideDown(300);
        var popMargTop = ($(loginBox).height() + 24) / 2;
        var popMargLeft = ($(loginBox).width() + 24) / 2;
        $(loginBox).css({
            'margin-bottom' : -popMargTop,
            'margin-left' : -popMargLeft
        });
        return false;
    });

// Aizver iznirstošo paneli
    $('a.close').on('click', function() {
        $('#mask , .login-popup').slideUp(300);
        return false;
    });
});

$(document).ready(function() {
    $('a.submit-window').click(function() {
        var submitBox = $(this).attr('href');
        $(submitBox).slideDown(300);
        var popMargTop = ($(loginBox).height() + 24) / 2;
        var popMargLeft = ($(loginBox).width() + 24) / 2;
        $(submitBox).css({
            'margin-bottom' : -popMargTop,
            'margin-left' : -popMargLeft
        });
        return false;
    });

// Aizver iznirstošo paneli
    $('a.close').on('click', function() {
        $('#mask , .submit-popup').slideUp(300);
        return false;
    });
});

//Aizver paziņojumu
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
        if (!files.length || !window.FileReader) return; // Nav izvēlēts fails
 
        if (/^image/.test( files[0].type)){
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = function(){ // parāda bildi
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });

    // priekš konkursa galvenes
    $("#headerFile").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return;
        if (/^image/.test( files[0].type)){
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = function(){
                $("#headerPreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});

//Sekojošā sidebar josla
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
        }
        else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });
});

// Iesūtīšanas loga loģistika
$(document).ready(function() {
    $('.subm-window').click(function () {
        var hideThis = $(this).data('id');
        $('.fullinfo[data-id=' + hideThis + ']').slideUp(500, function () {
            $(this).hide();
            $('.subminfo[data-id=' + hideThis + ']').slideDown(500, function () {
                $(this).show();
            });
        });
        // kad tiek beigts rakstīt sc.com saite, parāda kā tas izsaktās.
        $('.scLink[data-id='+hideThis+']')
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
        // aizver attiecīgo lauku
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

$(document).ready(function() {
// ielādē jq datapickeru
    $(".datepicker").datepicker();
});
