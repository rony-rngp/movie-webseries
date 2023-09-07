@extends('layouts.frontend.app')

@section('title', 'Home')

@push('css')
    <link href="{{ asset('frontend') }}/front-page-category/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/front-page-category/css/responsive.css" rel="stylesheet">
@endpush

@section('content')

    <div class="main-slider">
        <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
             data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
             data-swiper-breakpoints="true" data-swiper-loop="true" >
            <div class="swiper-wrapper">


                @foreach($categories as $category)
                <div class="swiper-slide">
                    @if($category->subcategories->count() != 0)
                        <a class="slider-category" href="{{ route('subcategory',[$category->id,$category->slug]) }}">
                            <div class="blog-image"><img src="{{ file_exists(public_path('backend/upload/category/'.$category->image)) ? url('backend/upload/category/'.$category->image) : '' }}" alt="{{ $category->name }}"></div>

                            <div class="category">
                                <div class="display-table center-text">
                                    <div class="display-table-cell">
                                        <h3><b>{{ Str::limit($category->name, 60) }}</b></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <a class="slider-category" href="{{ route('videos',[$category->id,$category->slug]) }}">
                            <div class="blog-image"><img src="{{ file_exists(public_path('backend/upload/category/'.$category->image)) ? url('backend/upload/category/'.$category->image) : '' }}" alt="{{ $category->name }}"></div>

                            <div class="category">
                                <div class="display-table center-text">
                                    <div class="display-table-cell">
                                        <h3><b>{{ Str::limit($category->name, 60) }}</b></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                </div><!-- swiper-slide -->
                @endforeach
            </div><!-- swiper-wrapper -->

        </div><!-- swiper-container -->

    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{ file_exists(public_path('backend/upload/category/'.$category->image)) ? url('backend/upload/category/'.$category->image) : '' }}" alt="{{ $category->name }}"></div>

                            <a class="avatar" href="#"><img src="{{ asset('frontend') }}/images/icons8-team-355979.jpg" alt="Profile Image"></a>

                            <div class="blog-info">

                                <h4 class="title"><a href="#"><b>{{ Str::limit($category->name, 60) }}</b></a></h4>

                                <ul class="post-footer">
                                    @if($category->subcategories->count() != 0)
                                        <a href="{{ route('subcategory',[$category->id,$category->slug]) }}" class="btn btn-block btn-outline-danger">Click Here</a>
                                    @else
                                        <a href="{{ route('videos',[$category->id,$category->slug]) }}" class="btn btn-block btn-outline-danger">Click Here</a>
                                    @endif
                                </ul>

                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-lg-4 col-md-6 -->
                @endforeach
            </div><!-- row -->

            {{--        <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>--}}

        </div><!-- container -->
    </section><!-- section -->

@endsection

@push('js')

@endpush
