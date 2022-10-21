<!DOCTYPE html>
<html lang="en">
<head>

    <title>@yield('title','Edumind')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Edumind s an online learning and teaching website">

    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">

    <!-- Favicon -->
    <link rel='shortcut icon' type='image/x-icon' href='{{asset('images/favicon.ico')}}' />

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('css/icons.css')}}">
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css'>

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{asset('css/uikit.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/tailwind.css')}}">




    @yield('css-files')

    {{--    --}}
    <!-- <link rel="stylesheet" type="text/css" href="./assets/css/1jquery.datetextentry.css"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.steps.css')}}">

    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">  -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet"> -->
    <!--  <link rel="stylesheet" href="./assets/css/summernote-bs4.css"> -->
    <link rel="stylesheet" href="{{asset('summernote-0.8.18/summernote-lite.css')}}">

    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css'>

    <link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />




    <link rel="stylesheet" href="{{asset('css/custom-styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">

    @yield('page-css')

</head>

<body>

    <?php
    $wrapperCls = isset($wrapperCls) ? $wrapperCls : "horizontal";
    ?>

    <div id="wrapper" class="<?php echo $wrapperCls ?>">

        <?php

            if(isset($page) && $page == 'home'){
                $headerCls = 'class="is-transparent is-dark border-b backdrop-filter backdrop-blur-2xl" uk-sticky="cls-inactive: is-dark is-transparent border-b"';
            }else{
                $headerCls = 'uk-sticky';
            }

            //$headerCls = ($page == 'home')?'class="is-transparent is-dark border-b backdrop-filter backdrop-blur-2xl" uk-sticky="cls-inactive: is-dark is-transparent border-b"':'uk-sticky';
            //echo $headerCls;

            /*header class
            courses.html ->  <header  uk-sticky>*/
        ?>

    	<!--  Header  -->
        <header <?php echo $headerCls; ?>>
            <div class="header_inner">

                @include('includes.left-side-nav')

                @include('includes.right-side-nav')

            </div>
        </header>
