<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>@yield('title') | Movie & Video</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <meta name="meta_title" content="{{ @$meta_title ? $meta_title : 'Blog' }}">
    <meta name="meta_tags" content="{{ @$meta_keywords ? $meta_keywords : 'Blog, Rony' }}">
    <meta name="keywords" content="{{ @$meta_keywords ? $meta_keywords : 'Blog, Rony' }}">
    <meta name="description" content="{{ @$meta_description ? $meta_description : 'Blog Project' }}">
    <!--Facebook-->
    <meta property="og:url" content="{{ @$url }}" >
    <meta property="og:title" content="{{ @$meta_title ? $meta_title : 'Blog' }}" >
    <meta property="og:description" content="{{ @$meta_description ? $meta_description : 'Blog Project' }}" >
    @if(!empty($og_image))
    <meta property="og:image" content="{{$og_image }}" />
    @endif




    <!-- Stylesheets -->

    <link href="{{ asset('frontend/common-css/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/common-css/swiper.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/common-css/ionicons.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/iziToast.css') }}">


    @stack('css')

</head>
<body >

<!-- Header -->
@include('layouts.frontend.partial.header')

@yield('content')

<!-- Footer -->
@include('layouts.frontend.partial.footer')


<!-- SCIPTS -->

<script src="{{ asset('frontend') }}/common-js/jquery-3.1.1.min.js"></script>

<script src="{{ asset('frontend') }}/common-js/tether.min.js"></script>

<script src="{{ asset('frontend') }}/common-js/bootstrap.js"></script>

<script src="{{ asset('frontend') }}/common-js/swiper.js"></script>

<script src="{{ asset('frontend') }}/common-js/scripts.js"></script>

<script src="{{ asset('js/iziToast.js') }}"></script>

@include('vendor.lara-izitoast.toast')

@stack('js')

</body>
</html>
