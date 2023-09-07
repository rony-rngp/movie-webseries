@extends('layouts.frontend.app')

@section('title')
    {{ $cms->title }}
@endsection

@push('css')

    <link href="{{ asset('frontend') }}/blank-static/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/blank-static/css/responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .social-btn-sp #social-links {
            margin: 0 auto;
            max-width: 500px;
        }
        .social-btn-sp #social-links ul li {
            display: inline-block;
        }
        .social-btn-sp #social-links ul li a {
            padding: 15px;
            border: 1px solid #ccc;
            margin: 1px;
            font-size: 30px;
        }
         #social-links{
            display: inline-table;
        }
         #social-links ul li{
            display: inline;
        }
         #social-links ul li a{
            padding: 5px;
            border: 1px solid #ccc;
            margin: 1px;
            font-size: 15px;
            background: #e3e3ea;
        }
    </style>

@endpush

@section('content')

    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>{{ $cms->title }}</b></h1>
    </div>


    <section class="blog-area section">
        <div class="container">
            <h4 class="text-left">
                <a style="color: blue" href="{{ url('/') }}"><u><i>Home</i></u></a>
                <i> / {{ $cms->title }}</i>
            </h4><br><br>
            <div class="row">

                <div class=" col-md-12">
                    <div class="post-wrapper">

                        <h3 class="title"><b>{{ $cms->titlr }}</b></h3>

                        <ul class="list-group">
                            <div>{!! $cms->description !!}</div>
                        </ul>

                        {!! $shareButtons !!}


                    </div><!-- post-wrapper -->
                </div><!-- col-sm-8 col-sm-offset-2 -->
            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->



@endsection

@push('js')

@endpush
