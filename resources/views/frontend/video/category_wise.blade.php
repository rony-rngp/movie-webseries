@extends('layouts.frontend.app')

@section('title')
    {{ $category->name }}
@endsection

@push('css')

    <link href="{{ asset('frontend') }}/layout-1/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/layout-1/css/responsive.css" rel="stylesheet">

    <style>
        .favorite_posts{
            color: blue;
        }

    </style>
@endpush

@section('content')

    <div class="center-text">
        <img src="{{ url('backend/upload/category/slider/'.$category->image) }}" class="img-fluid" alt="Responsive image">
    </div><!-- slider -->


    <section class="blog-area section">
        <div class="container">
            <h4 class="text-left">
                <a style="color: blue" href="{{ url('/') }}"><u><i>Home</i></u></a>
                <i> / {{ $category->name }}</i>
            </h4><br><br>
            <div class="row">
                @forelse($movies as $movie)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{ url('backend/upload/video/'.$movie->image) }}" alt="{{ $movie->title }}"></div>

                            <a class="avatar" href="#"><img src="{{ asset('frontend') }}/images/icons8-team-355979.jpg" alt="Profile Image"></a>

                            <div class="blog-info">

                                <h4 class="title"><a href="{{ route('video.details',[$movie->id, $movie->slug]) }}"><b>{{ $movie->title }}</b></a></h4>


                                <ul class="post-footer">
                                    <li><a href="{{ route('user.favorite', $movie->id) }}"><i class="ion-heart
                                     <?php
                                        foreach ($movie->favorites as $favorite){
                                        if ($favorite->user_id == isset(Auth::user()->id)){ ?>
                                            favorite_posts
                                            <?php }
                                        }
                                        ?>
                                    "></i>{{ $movie->favorites->count() }}</a></li>
                                    <li><a href="#"><i class="ion-chatbubble"></i>{{ $movie->comment_count->count() }}</a></li>
                                    <li><a href="#"><i class="ion-eye"></i>{{ $movie->view_count }}</a></li>
                                </ul>

                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-lg-4 col-md-6 -->
                @empty
                    <div class="col-md-12">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <h3 class="mt-4">Data Not Found ):</h3>
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforelse
        </div><!-- row -->

{{--            <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>--}}

        </div><!-- container -->
    </section><!-- section -->


@endsection

@push('js')

@endpush
