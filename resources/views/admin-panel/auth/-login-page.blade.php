<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>ADMIN Login | Edumind</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="{{asset('admin/img/favicon.ico')}}" type="image/x-icon" />
        <!-- END META SECTION -->


        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('admin/css/login/theme-default-head-light.css')}}"/>
        <!-- EOF CSS INCLUDE -->

        <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css'>

        <style>
            /* ------------------------------------ */
            /* Show/Hide password field ------------*/
            /* ------------------------------------ */
            .password-container{
                position: relative;
            }
            .password-container .pw-toggle{
                background: none;
                border: none;
                color: #337ab7;
                /* display: none; */
                font-size: 1.3em;
                font-weight: 600;
                /* padding: .5em; */
                position: absolute;
                right: 7px;
                top: 7px;
                z-index: 9;
            }

            /* ------------------------------------ */
            /* custom flash messages ------------*/
            /* ------------------------------------ */
            .flash-msg {
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            .flash-success {
                color: #3c763d;
                background-color: #dff0d8;
                border-color: #d6e9c6;
            }
            .flash-info {
                color: #31708f;
                background-color: #d9edf7;
                border-color: #bce8f1;
            }
            .flash-warning {
                color: #8a6d3b;
                background-color: #fcf8e3;
                border-color: #faebcc;
            }
            .flash-danger {
                color: #a94442;
                background-color: #f2dede;
                border-color: #ebccd1;
            }
        </style>
    </head>
    <body>

        <div class="login-container">

            <div class="login-box animated fadeInDown">
                <div class="login-logo1"></div>
                <div class="login-body">
                    <div class="login-title">LOGIN</div>


                    @if(Session::has('message'))
                        <x-flash-message  
                            :class="Session::get('cls', 'flash-info')"  
                            :title="Session::get('msgTitle') ?? 'Info!'" 
                            :message="Session::get('message') ?? ''"  
                            :message2="Session::get('message2') ?? ''"  
                            :canClose="true" />
                    @endif



                    <form action="" class="form-horizontal" method="post" autocomplete="off">

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Username or Email *" name="uname" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="password-container">
                                    <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                           name="password" maxlength="12" minlength="6" required/>
                                    <button type="button" id="btnToggle" class="pw-toggle">
                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <button class="btn btn-info btn-block" name="admin_submit">Log In</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-warning btn-block" name="admin_submit">Reset</button>
                            </div>
                        </div>

                        <div class="form-group" id="" style="margin-top:15px;">
                            <div class="col-md-6" style="color:#fff;">
                                <span style="color:red;">*</span> - Required Fields
                            </div>
                        </div>

                        {{ csrf_field() }}
                    </form>

                </div>

            </div>

        </div>

        <script src="{{asset('admin/js/jquery-3.1.1.min.js')}}"></script>
        <script>
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


			$('.flash-msg .close').click(function(event){
				$(this).parent().fadeOut(700, function(){ $(this).remove();});
			});
        </script>
    </body>
</html>
