@extends('layouts.frontend.app')

@section('title')
    {{ $subcategories[0]->category->name }}
@endsection

@push('css')

    <link href="{{ asset('frontend') }}/blank-static/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/blank-static/css/responsive.css" rel="stylesheet">


@endpush

@section('content')

    <div class="center-text">
        <img src="{{ url('backend/upload/category/slider/'.$subcategories[0]->category->image) }}" class="img-fluid" alt="Responsive image">

    </div><!-- slider -->


    <section class="blog-area section">
        <div class="container">
            <h4 class="text-left">
                <a style="color: blue" href="{{ url('/') }}"><u><i>Home</i></u></a>
                <i> / {{ $subcategories[0]->category->name }}</i>
            </h4><br><br>
            <div class="row">

                <div class=" col-md-12">
                    <div class="post-wrapper">

                        <ul class="list-group">
                            @foreach($subcategories as $subcategory)
                                @if($subcategory->sub_subcategories->count() != 0)
                                    <a href="{{ route('sub.subcategory', [$subcategory->id, $subcategory->slug]) }}">
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            {{ $subcategory->name }}
                                        </li>
                                    </a>
                                @else
                                    <a href="{{ route('videos.subcategory',[$subcategory->id, $subcategory->slug]) }}">
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            {{ $subcategory->name }}
                                        </li>
                                    </a>
                                @endif


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
