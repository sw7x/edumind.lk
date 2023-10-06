
        <!-- Footer -->
        <footer class="footer-area footer--light">
            <div class="footer-big">
                <!-- start .container -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="footer-widget">
                                <div class="widget-about">
                                    <div class="logo">                                
                                        <a href="{{url('/')}}" title="Edumind">
                                            <img src="{{asset('images/logo.png')}}" alt="" class="img-fluid">
                                        </a>
                                    </div>

                                    <div class="contact-details-div">                                        
                                        <ul class="contact-details">
                                            <li>
                                                <span class="icon icon-feather-phone-incoming"></span>Call Us:
                                                <a href="tel:+94771755556">+94771755556</a>
                                            </li>
                                            <li>
                                                <span class="icon icon-feather-mail"></span>Email:
                                                <a href="mailto:info@abc.lk">info@abc.lk</a>
                                            </li>
                                            <li>
                                                <span class="icon icon-feather-map-pin"></span>Address:
                                                <address class="mt-1 mb-1">402, Galle Road, Colombo 03</address>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="social-links-div flex items-left space-x-3 justify-left mt-5">
                                        <a href="#">
                                            <ion-icon name="logo-facebook" class="border-2 border-blue-600 p-2 rounded-full text-4xl bg-gray-100 text-blue-600"></ion-icon>
                                        </a>
                                        <a href="#">
                                            <ion-icon name="logo-twitter" class="border-2 border-blue-600 p-2 rounded-full text-4xl bg-gray-100 text-indigo-500"></ion-icon>
                                        </a>
                                        <a href="#">
                                            <ion-icon name="logo-instagram" class="border-2 border-blue-600 p-2 rounded-full text-4xl bg-gray-100"></ion-icon>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <!-- Ends: .footer-widget -->
                        </div>
                        <!-- end /.col-md-4 -->
                        
                        @if(isset($subject_info) && isNotEmptyArray($subject_info))
                            <div class="col-md-3 col-sm-4">
                                <div class="footer-widget">
                                    <div class="footer-menu footer-menu--1">
                                        
                                        <h4 class="footer-widget-title">Popular Subjects</h4>
                                        <ul>
                                            @foreach($subject_info as $subArr)
                                                <li><a href="{{route('subjects.show',$subArr['slug'])}}">{{$subArr['name']}}</a></li>
                                                @if($loop->index >= 4)
                                                {{--
                                                @break
                                                --}}
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- end /.footer-menu -->
                                </div>
                                <!-- Ends: .footer-widget -->
                            </div>
                            <!-- end /.col-md-3 -->
                        @endif

                        <div class="col-md-3 col-sm-4">
                            <div class="footer-widget">
                                <div class="footer-menu">
                                    <h4 class="footer-widget-title">Our Company</h4>
                                    <ul>
                                        <li><a href="{{route('home')}}">Home</a></li>
                                        <li><a href="{{route('subjects.index')}}">Subject List</a></li>
                                        <li><a href="{{route('courses.search')}}">Search</a></li>
                                        <li> <a href="{{route('view-cart')}}">cart</a></li>
                                    </ul>
                                </div>
                                <!-- end /.footer-menu -->
                            </div>
                            <!-- Ends: .footer-widget -->
                        </div>
                        <!-- end /.col-lg-3 -->

                        <div class="col-md-3 col-sm-4">
                            <div class="footer-widget">
                                <div class="footer-menu no-padding">
                                    <h4 class="footer-widget-title">Help Support</h4>
                                    <ul>
                                        <li><a href="{{route('about-us')}}">EDUMIND අපි</a></li>
                                        {{--todo <li><a href="{{route('privacy-policy')}}">Privacy policy</a></li>--}}
                                        <li><a href="{{route('terms-and-services')}}">ලබාගත හැකි ආදායම</a></li>
                                        <li><a href="{{route('why-choose-us')}}">ප්රතිලාභ</a></li>
                                        <li><a href="{{route('instructions')}}">Teach on Udemy</a></li>
                                        <li><a href="{{route('contact-us.view')}}">Contact</a></li>
                                    </ul>
                                </div>
                                <!-- end /.footer-menu -->
                            </div>
                            <!-- Ends: .footer-widget -->
                        </div>
                        <!-- Ends: .col-lg-3 -->

                    </div>
                    <!-- end /.row -->
                </div>
                <!-- end /.container -->
            </div>
            <!-- end /.footer-big -->

            <div class="mini-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright-text">
                                <p class="bold">Copyright © <?php echo date("Y"); ?>
                                    <a class="text-white" href="{{url('/')}}">Edumind</a>.&nbsp;All Rights Reserved
                                    {{--Created by <a href="#">AazzTech</a>--}}
                                </p>
                            </div>

                            <!-- todo later
                            <div class="go_top">
                                <span class="icon-arrow-up"></span>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    @yield('bootstrap-modals')


    <!-- Javascript
    ================================================== -->
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jquery UI -->
    <script src="{{asset('admin/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>


    <script src="{{asset('js/uikit.js')}}"></script>
    <script src="{{asset('js/tippy.all.min.js')}}"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="//unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>



    @yield('script-files')
    {{--

    <script src="{{asset('js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('summernote-0.8.18/summernote-lite.js')}}"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'></script>
    <script  src="{{asset('js/dropzone.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    ---}}

    <script src="{{asset('js/script.js')}}"></script>
    @yield('javascript')


    <script type="text/javascript">

        $(document).ready(function () {

            var $element = $('#mobile-nav-slider');
            var mobileNavSlider = UIkit.offcanvas($element,{
                overlay: true,
                mode: 'push'
            });

            $(document).on('hidden', $element, function() {
                console.log('hidden');
                if(!$element.hasClass('uk-open')){
                    $('.toggle-btn-div').removeClass('on');
                }
            });

            $(document).on('shown', $element, function() {
                console.log('shown');
                if($element.hasClass('uk-open')){
                    $('.toggle-btn-div').addClass('on');
                }
            });


            $(document).click(function (event) {
                var clickover   = $(event.target);
                var _opened     = $("#mobile-nav-slider").hasClass("uk-open");

                // click bypass for slide nav menu
                if(clickover.parents('#mobile-nav-slider').length){
                    return;
                }

                if(clickover.hasClass('toggle-btn-div') || clickover.parent().hasClass('toggle-btn-div')){
                    mobileNavSlider.toggle();
                    //UIkit.offcanvas('#mobile-nav-slider').toggle();
                    //UIkit.offcanvas('#mobile-nav-slider').show();
                    //UIkit.offcanvas('#mobile-nav-slider').hide();
                }
            });

        });



        $(window).on('resize', function(){
            var win_width  = $(window).width();
            if (win_width > 1024) {
                UIkit.offcanvas('#mobile-nav-slider').hide();
            }
        });



        //todo - delete  - ()
        function _toggleNav(event){
            event.stopPropagation();

            if(!$(event.target).hasClass('toggle-btn-div')){
                $toggleBtn = $(event.target).parent();
            }else{
                $toggleBtn = $(event.target);
            }
            $subDivs    = $toggleBtn.find('div');

            /*  use to not execute event handler again until removing is-visible class
                from .header_menu
            */
            if($toggleBtn.hasClass('disable-cls')){
                return;
            }


            $toggleBtn.toggleClass('on');

            if($toggleBtn.hasClass('on')){
                UIkit.offcanvas('#mobile-nav-slider').show();

            }else{
                $toggleBtn.addClass('disable-cls');
                UIkit.offcanvas('#mobile-nav-slider').hide();
                $toggleBtn.removeClass('disable-cls');

                /*
                $('nav.header_menu').hide("slide", { direction: "left" }, function(){
                    $('nav.header_menu').removeClass("is-visible");
                    $toggleBtn.removeClass('disable-cls');
                });
                */
            }
        }

        //$(".toggle-btn-div").on( "click", toggleNav);
        //$(".toggle-btn-div").find('div').on( "click", toggleNav);

    </script>

</body>

</html>
