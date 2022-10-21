<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Edumind - Coming Soon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,700i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.17/tailwind.min.css">




    <style type="text/css">
    :root {
        --color: #DDD;
        --bgc: #333;
        --a: #333;
        --hc: #FFF;
        --hbgc: #333;
        --round: 50%;
    }

    ::-moz-selection {
        background-color: var(--hbgc);
        color: var(--hc);
    }

    ::selection {
        background-color: var(--hbgc);
        color: var(--hc);
    }

    html {
        font: 75%/1 Lato, sans-serif;
    }

    body {
        margin: 0;
        padding: 0;
        color: var(--color);
        background: var(--bgc);
        width: 100%;
        height: 100%;
    }

    h1, h2, h3, p, ul, li, a {
        margin: 0;
        padding: 0;
    }

    ul {
        display: inherit;
        list-style: none;
    }

    a, a:visited, a:active, a:link, a:hover {
        text-decoration: none;
        color: var(--a);
        text-transform: uppercase;
        transition: all 0.5s;
    }

    .grid {
        display: grid;
        grid-column: 2/4;
        grid-template-columns: 1fr repeat(2, minmax(auto, 25rem)) 1fr;
    }

    .grid2 {
        display: grid;
        grid-template-columns: [xl-start] 1fr 1.5rem [md-start] minmax(0, 624px) [md-end] 1.5rem 1fr [xl-end];
    }

    .grid2 * {
        grid-column: md;
    }

    .grid2-xl {
        grid-column: xl;
    }

    .cf {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .ct {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .ol {
        background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("https://images.unsplash.com/reserve/URG2BbWQQ9SAcqLuTOLp_BP7A9947.jpg?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=4b303ea3a7149481da183fdfa430068") top/cover no-repeat fixed;
    }

    .full {
        max-height: 100%;
        height: 100vh;
        width: 100%;
    }

    .al {
        text-align: left;
    }

    .ac {
        text-align: center;
    }

    .aj {
        text-align: justify;
    }

    .container {
        width: 100%;
    }
    .container h1 {
        text-transform: uppercase;
        font-size: 5rem;
        margin: 1.8rem;
        letter-spacing: 0.8rem;
    }
    .container h2 {
        font-size: 1.6rem;
        font-weight: 700;
        font-style: italic;
    }
    .container .count {
        margin-top: 3rem;
    }
    .container .count .countd {
        display: inline-block;
        width: 7.5rem;
        height: 7.5rem;
        border: 5px solid;
        border-radius: var(--round);
        margin: 0 2.5rem 2.5rem;
        overflow: hidden;
        text-transform: uppercase;
    }
    .container .count .countd span {
        display: block;
        font-size: 2rem;
        margin-top: 1.6rem;
    }
    .wrapper {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        animation: fadeIn 1000ms ease;
        -webkit-animation: fadeIn 1000ms ease;
    }
    .icons {
        text-align: center;

    }
    .icons i {
        /*
        color: #00091B;
        background: #fff;
        height: 15px;
        width: 15px;
        padding: 13px;
        margin: 0 20px;
        border-radius: 50px;
        border: 2px solid #fff;
        transition: all 200ms ease;
        text-decoration: none;
        position: relative;*/
        color: #ffffff;
        height: 50px;
        width: 50px;
        padding: 0px;
        margin: 0 15px;
        transition: all 200ms ease;
        text-decoration: none;
        position: relative;
        font-size: 50px;
    }

    .icons i:hover, .icons i:active {
        color: #fff;
        background: none;
        cursor: pointer !important;
        transform: scale(1.2);
        -webkit-transform: scale(1.2);
        text-decoration: none;
    }

    @media screen and (max-width: 575px) {
        .countd {
            margin: 0 4.6rem 4.6rem !important;
        }
    }
    @media screen and (max-width: 430px) {
        .countd {
            margin: 0 2.5rem 2.5rem !important;
        }
    }
    </style>

</head>
<body>
    <!-- partial:index.partial.html -->
    <body class="">
        <div class="container ct ac">
            <!-- <h1>Logo</h1> -->

            <div id="logo" class="">
                <img class="m-auto" width="400" src="{{asset('images/logo-light.png')}}" alt="logo">
            </div>



            <h2>We Are Coming Soon.</h2>
            <div class="w-2/4 m-auto my-5">
                <p class="text-2xl ">Our website is under construction. We`ll be here soon with our new awesome site.</p>
            </div>

            <div class="count">
                <div class="countd">
                    <span id="days">00</span>
                    days
                </div>
                <div class="countd">
                    <span id="hours">00</span>
                    hours
                </div>
                <div class="countd">
                    <span id="mins">00</span>
                    minutes
                </div>
                <div class="countd">
                    <span id="secs">00</span>
                    seconds
                </div>
            </div>

            <div class="">
                <div class="icons m-auto">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>



        </div>
    </body>


    <!-- partial -->

    <script type="text/javascript">
        var count = new Date("dec 7,2021 00:00:00").getTime();
        var x = setInterval( function() {
            var now = new Date().getTime();
            var d = count - now;
            var days = Math.floor(d/(1000*60*60*24));
            var hours = Math.floor((d%(1000*60*60*24))/(1000*60*60));
            var minutes = Math.floor((d%(1000*60*60))/(1000*60));
            var seconds = Math.floor((d%(1000*60))/1000);
            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("mins").innerHTML = minutes;
            document.getElementById("secs").innerHTML = seconds;
        },1000);
    </script>
</body>
</html>
