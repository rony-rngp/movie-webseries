@extends('layouts.frontend.app')

@section('title')
    {{ $sub_subcategories[0]->subcategory->category->name }}
@endsection

@push('css')

    <link href="{{ asset('frontend') }}/blank-static/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/blank-static/css/responsive.css" rel="stylesheet">

@endpush

@section('content')

    <div class="center-text">
        <img src="{{ url('backend/upload/category/slider/'.$sub_subcategories[0]->subcategory->category->image) }}" class="img-fluid" alt="Responsive image">
    </div><!-- slider -->


    <section class="blog-area section">
        <div class="container">
            <h4 class="text-left">
                <a style="color: blue" href="{{ url('/') }}"><u><i>Home</i></u></a>
                <i> / <a style="color: blue" href="{{ route('subcategory', [$sub_subcategories[0]->subcategory->category->id, $sub_subcategories[0]->subcategory->category->slug  ]) }}"><u>{{ $sub_subcategories[0]->subcategory->category->name }}</u></a></i>
                <i> / {{ $sub_subcategories[0]->subcategory->name }}</i>
            </h4><br><br>
            <div class="row">

                <div class=" col-md-12">
                    <div class="post-wrapper">

                        <h3 class="title"><a href="{{ route('subcategory', [$sub_subcategories[0]->subcategory->category->id, $sub_subcategories[0]->subcategory->category->slug]) }}"><b>{{ $sub_subcategories[0]->subcategory->category->name }}</b></a></h3>

                        <ul class="list-group">
                            @foreach($sub_subcategories as $sub_subcategory)
                                    <a href="{{ route('videos.sub.subcategory',[$sub_subcategory->id, $sub_subcategory->slug]) }}">
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            {{ $sub_subcategory->name }}
                                        </li>
                                    </a>
                            @endforeach
                        </ul>

                    </div><!-- post-wrapper -->
                </div><!-- col-sm-8 col-sm-offset-2 -->
            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->



@endsection

@push('js')

@endpush
