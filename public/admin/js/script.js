


$('.flash-msg .close').click(function(event){
    $(this).parent().fadeOut(700, function(){ $(this).remove();});
    event.preventDefault();
    event.stopPropagation();
});



// Show/Hide password field
$('.pw-toggle').click(function(event){
    let icon          = $(this).children('i');
    let passwordInput = $(this).parent().find('input.password_field');

    if (passwordInput.attr('type') === 'password') {
        passwordInput.prop('type', 'text');
        icon.addClass("fa-eye-slash");
    } else {
        passwordInput.prop('type', 'password');
        icon.removeClass("fa-eye-slash");
    }
    //icon.addClass('aa');
    //passwordInput.addClass('bb');
});


//admin panel change password
$('#admin_change_password input[name="change_password_submit"]').click(function(event){

    let password_old = $('#admin_change_password input[name="password_old"]').val();
    let password_new = $('#admin_change_password input[name="password_new"]').val();

    if(password_old == ''){
        $('#changePasswordStatus p').html('invalid value for current password');
        $('#changePasswordStatus p').removeClass('text-green-700');
        $('#changePasswordStatus p').addClass('text-red-700');
    }else if(password_new ==''){
        $('#changePasswordStatus p').html('invalid value for new password');
        $('#changePasswordStatus p').removeClass('text-green-700');
        $('#changePasswordStatus p').addClass('text-red-700');
    }else{
        $.ajax({
            url: changepwUrl,
            type: "post",
            data: {
                old_password : password_old,
                password : password_new,
                _token :'{{csrf_token ()}}'
            } ,
            success: function (response) {

                if(response['status'] == 'success'){
                    $('#changePasswordStatus p').html('Suceess');
                    $('#changePasswordStatus p').addClass('text-green-700');
                    $('#changePasswordStatus p').removeClass('text-red-700');

                    $("#chngpwclose").trigger('click');

                }else{
                    $('#changePasswordStatus p').html('Error');
                    $('#changePasswordStatus p').removeClass('text-green-700');
                    $('#changePasswordStatus p').addClass('text-red-700');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                $('#changePasswordStatus p').html('Error');
                $('#changePasswordStatus p').removeClass('text-green-700');
                $('#changePasswordStatus p').addClass('text-red-700');
            }
        });
    }

    event.preventDefault();
});



$(document).on('click', 'a.no-clickable', function (event){
    event.preventDefault();
    event.stopPropagation();
});


// change password popup
$(document).on('click', '#chngpwclose', function (event){

    $('#admin_change_password input[name="password_old"]').val('');
    $('#admin_change_password input[name="password_new"]').val('');

    $('#changePasswordStatus > p').html('');
    //$('#mb-change-pw').removeClass('open');

    $('#mb-change-pw').fadeOut("slow", function() {
        $(this).removeClass("open");
    });
    event.preventDefault();
});

$(document).on('click', '#chngpwlink', function (event){
    $('#admin_change_password input[name="password_old"]').val('');
    $('#admin_change_password input[name="password_new"]').val('');

    $('#changePasswordStatus > p').html('');
    //$('#mb-change-pw').removeClass('open');

    $('#mb-change-pw').fadeIn("slow", function() {
        $(this).addClass("open");
    });
    event.preventDefault();
});




// logout password popup
$(document).on('click', '#signoutlink', function (event){
    $('#mb-signout').fadeIn("slow", function() {
        $(this).addClass("open");
    });
    event.preventDefault();
});

$(document).on('click', '#chngLogoutclose', function (event){
    $('#mb-signout').fadeOut("slow", function() {
        $(this).removeClass("open");
    });
    event.preventDefault();
});



$('form.admin-logout-form a.logout').click(function(event){
    //$(this).parent().addClass('aahidden');
    $(this).parent().submit();
    //onclick="document.getElementById('logout-form').submit();"
    event.preventDefault();
});

$('form.admin-logout-form a.closeBtn').click(function(event){
    $('#mb-signout').fadeOut("slow", function() {
        $(this).removeClass("open");
    });
    event.preventDefault();
});




//var config = {draggablePnelsEnable : true}
$(document).ready(function(){
    //<!-- Enable portlets -->
    //WinMove();

    if($('.i-checks').length > 0){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    }


});
















var swaeatAlert2 = {

    //icon = warning, error, success, info, question

    popup:function(icon,txtMsg,txt){

        txtMsg = (txtMsg)?txtMsg:'Posted successfully';
        icon   =(icon)?icon:'success';
        txt   =(txt)?txt:'';

        Swal.fire({
            icon: icon,
            title: txtMsg,
            text:txt,
            animation: true,
            //position: 'bottom',
            showConfirmButton: false,
            timer: 2300,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    },

    toast :function(icon,txtMsg){

        txtMsg = (txtMsg)?txtMsg:'Posted successfully';
        icon   =(icon)?icon:'success';

        Swal.fire({
            toast: true,
            icon: icon,
            title: txtMsg,
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2300,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

    },
};





var getLastPartOfUrl = function($url) {
    var url = $url;
    var urlsplit = url.split("/");
    var lastpart = urlsplit[urlsplit.length - 1];
    if (lastpart === '') {
        lastpart = urlsplit[urlsplit.length - 2];
    }
    return lastpart;
}


// check whether a string is valid HTTP URL
function isValidHttpUrl(string) {
    let url;
    try {
        url = new URL(string);
    } catch (_) {
        return false;
    }
    return url.protocol === "http:" || url.protocol === "https:";
}