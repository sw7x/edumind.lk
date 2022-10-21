            <div class="footer">
                <div class="float-right">
                    <strong>Edumind</strong>.
                </div>
                <div>
                    <strong>Copyright</strong> Edumind &copy; <?php echo date("Y",strtotime("-1 year")); ?> - <?php echo date("Y"); ?>
                </div>
            </div>

        </div>
    </div>




@yield('bootstrap-modals')


<div class="modal fade" id="modal-update-t-salary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">modal-update-t-salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Date:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" placeholder="" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Pay</button>
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="message-box animated" data-sound="" id="mb-change-pw" role="dialog">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title">
                <span class="fa fa-unlock"></span> Change Admin Password
                <button class="bg-red-800 hover:bg-red-500 btn btn-sm" style="float: right" id="chngpwclose">X</button>
                <div class="clear"></div>
            </div>
            <div class="mb-content"  id="changePasswordStatus">
                <p class="font-bold"></p>
            </div>

            <div class="mb-content">
                <form action="" id="admin_change_password" method="post" name="" autocomplete="off">

                    <div class="form-group password-container">
                        <label for="" style="float:left;padding:10px 0px;">Type Password<span></span></label><br/>
                        <input type="password" name="password_old" value="" id="passold" class="password_field form-control"
                               placeholder="Password (6 to 12 alpha numeric characters) *" maxlength="12" minlength="6" required />
                        <button type="button" id="btnToggle" class="pw-toggle">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </button>
                    </div>


                    <div class="form-group password-container">
                        <label for="" style="float:left;padding:10px 0px;">Type New Password<span></span></label><br/>
                        <input type="password" name="password_new" value="" id="passnew" class="password_field form-control"
                               placeholder="Password (6 to 12 alpha numeric characters) *" maxlength="12" minlength="6" required />
                        <button type="button" id="btnToggle" class="pw-toggle">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </button>
                    </div>

                    <div>
                        <div id="hint1" class="hint"></div>

                        <input class="btn bg-green-500 hover:bg-green-600 formbuttons text-white font-bold py-2 px-4 rounded" style="float:left" name="change_password_submit" type="submit" value="Submit" id="asd">
                        <input class="btn bg-red-600 hover:bg-red-600 formbuttons text-white font-bold py-2 px-4 rounded" style="float:right" name="" type="reset" value="Reset" id="">
                        <div class="clear"></div>
                    </div>
                </form>
                <br/><br/><br/>
            </div>
        </div>
    </div>
</div>

<div class="message-box animated" id="mb-signout" role="dialog">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title">
                <span class="fa fa-sign-out"></span><strong>Log Out ?</strong>
                <button class="bg-red-800 hover:bg-red-500 btn btn-sm" style="float: right" id="chngLogoutclose">X</button>
                <div class="clear"></div>
            </div>
            <div class="mb-content">
                <p>Are you sure you want to log out?</p>
                <p>Press No if you want to continue work. Press Yes to logout current user.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <form action="{{route('auth.logout')}}" method="post" class='admin-logout-form'>
                        {{csrf_field ()}}
                        <a href="" class="bg-red-600 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Yes</a>
                        <a href="#" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mb-control-close">No</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




    <!-- Mainly scripts -->
    <script src="{{asset('admin/js/jquery-3.1.1.min.js')}}"></script>

    <!-- jquery UI -->
    <script src="{{asset('admin/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Touch Punch - Touch Event Support for jQuery UI -->
    <script src="{{asset('admin/js/plugins/touchpunch/jquery.ui.touch-punch.min.js')}}"></script>

    <script src="{{asset('admin/js/popper.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.js')}}"></script>
    <script src="{{asset('admin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>

    <script src="{{asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>


    <!-- Custom and plugin javascript -->
    <script src="{{asset('admin/js/inspinia.js')}}"></script>
    <script src="{{asset('admin/js/plugins/pace/pace.min.js')}}"></script>







    @yield('script-files')
    {{--
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>

    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

    <!-- Data picker -->
   <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <!-- SUMMERNOTE -->
    <!-- <script src="../assets/summernote-0.8.18/summernote-lite.js"></script> -->
    <script src="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.js')}}"></script>


    <script src="{{asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>
            --}}



    <script>
	{{--
		var changepwUrl = '{{route('admin.changePassword')}}';
	--}}
    </script>



    <script src="{{asset('admin/js/script.js')}}"></script>


    @yield('javascript')




</body>
</html>
