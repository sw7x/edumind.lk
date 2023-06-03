@extends('layouts.master')
@section('title','Payment failed')




@section('content')

    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            
            <div class="---lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Payment failed</h2>
                        <hr class="mb-5">
                        
                        <div class="w-8/12 mx-auto">                            
                            <div class="flex justify-center">
                                <ion-icon name="alert-circle-sharp" class="text-9xl text-center text-red-500 course-status" title="Enrolled"></ion-icon>
                            </div> 
                            <br>
                            <p class="mb-2 text-base text-lg">
                                "Oops! We're sorry, {{$message ?? 'but there was an issue processing your payment.'}}
                            </p>
                            <br>
                            <p class="mb-2 text-lg __text-center font-semibold">Suggesstion</p>
                            <p class="mb-2 text-base">Please double-check the credit card information 
                                you entered and try again. If the problem persists, please contact our customer support for assistance."</p>
                            <br>
                        </div>

                        <hr>
                            
                        <div class="content centered mt-12">
                            <h1 class="font-semibold mb-2 text-xl text-center">What do you want to do next?</h1>                            
                            <div class="flex mt-5 justify-center">
                                <div class="mr-5">
                                    <a href="{{route('billing-info').'?key='.csrf_token()}}" title="" class="btn bg-red-500 hover:bg-red-600 font-semibold px-5 py-2 hover:text-white rounded-md text-center text-white w-full">Try again</a>
                                </div>
                                <div class="mr-5">
                                    <a href="{{route('home')}}" title="" 
                                        class="btn border border-blue-600 font-semibold px-5 py-2 hover:bg-blue-700 
                                        rounded-md text-center text-blue-600 hover:text-white w-full">Home</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>

            
        </div>
    </div>

@stop




@section('javascript')
    <script>
        

        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };


        /*
        history.pushState(null, null, location.href); 
        history.back(); 
        history.forward(); 
        window.onpopstate = function () { 
            history.go(1); 
        };
        

        history.pushState(null, '', location.href);
        window.onpopstate = function () {
          history.go(1);
        };

        */


        /*(function(window, location) {
            history.replaceState(null, document.title, location.pathname+"#!/history");
            history.pushState(null, document.title, location.pathname);

            window.addEventListener("popstate", function() {
                if(location.hash === "#!/history") {
                    history.replaceState(null, document.title, location.pathname);
                    setTimeout(function(){
                      location.replace("http://www.url.com");
                    },10);
                }
            }, false);
        }(window, location));

        */
    </script>
@stop