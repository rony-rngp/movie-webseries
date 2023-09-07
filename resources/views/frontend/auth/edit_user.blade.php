@extends('layouts.frontend.app')

@section('title', 'Dashboard')

@push('css')

    <link href="{{ asset('frontend') }}/blank-static/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/blank-static/css/responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('backend/dropify/dropify.min.css') }}">

@endpush

@section('content')



    <section class="blog-area section">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="post-wrapper">

                        <div class="row">

                            @include('frontend.auth.dashboard_sidebar')


                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-1">

                                    </div>
                                    <div class="col-md-10">
                                        <div class="panel">
                                            <div class="panel-body box-profile">
                                                <form id="updateDetails" action="{{ route('user.update.profile') }}" enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="info-title" for="name">Name <span style="color: red">*</span></label>
                                                        <input type="text" class="form-control unicase-form-control text-input" name="name" value="{{ $user->name }}" id="name">
                                                        <span style="color:red">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>

                                                    </div>

                                                    <div class="form-group">
                                                        <label class="info-title" for="email">Email Address</label>
                                                        <input  class="form-control unicase-form-control text-input" value="{{ $user->email }}" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="info-title" for="address">Image <span style="color: red">*</span></label>
                                                        <input type="file" name="image" class="form-control dropify"  data-max-file-size="3M" data-default-file="{{ url('backend/upload/users/'.$user->image)  }}" id="image" accept="image/*">
                                                        <span style="color:red">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                                    </div>



                                                    <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Update</button>
                                                </form><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div><!-- post-wrapper -->
                </div><!-- col-sm-8 col-sm-offset-2 -->
            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->



@endsection

@push('js')
    <script src="{{ asset('backend/dropify/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endpush
