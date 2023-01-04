<!DOCTYPE html>
<html>

<head>

    <title>@yield('title','Edumind | Admin Panel')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('admin/favicon.ico')}}" />
	
    <link href="{{asset('admin/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/animate.css')}}"/>
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/tailwind.min.css')}}" >


    @yield('css-files')
    {{--
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
    <!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">
    --}}

    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/custom-styles.css')}}" rel="stylesheet">

    @yield('page-css')

</head>
<body>
    <div id="wrapper">
