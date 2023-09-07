@extends('layouts.frontend.app')

@section('title', 'Dashboard')

@push('css')

    <link href="{{ asset('frontend') }}/blank-static/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/blank-static/css/responsive.css" rel="stylesheet">

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
                                                <div class="img-circle text-center">
                                                    <img style="width: 19%" class="profile-user-img img-fluid img-circle" src="{{ url('backend/upload/users/'.$user->image) }}" alt="User profile picture">
                                                </div><br>
                                                <h3 class="text-center">{{ $user->name }}</h3>
                                                <p class="text-center">{{ $user->address }}</p><br>
                                                <table class="table table-bordered" style="text-align: center">

                                                    <tr>
                                                        <td>E-Mail</td>

                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>

                                                        <td>{{ $user->status == 1 ? 'Active' : 'Inactive'}}</td>
                                                    </tr>
                                                </table>
{{--                                                <a class="btn btn-primary btn-block btn-sm" href="">Edit Profile</a>--}}
                                            </div>
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

@endpush
