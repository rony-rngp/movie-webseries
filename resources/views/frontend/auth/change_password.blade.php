@extends('layouts.frontend.app')

@section('title', 'Change Password')

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
                                                <form id="quickForm" action="{{ route('user.update.password') }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                                    @csrf
                                                    <div class="form-group col-md-12">
                                                        <label for="current_password">Current Password</label>
                                                        <input type="password" id="current_password" name="current_password" id="current_password" class="form-control" placeholder="Current Password">
                                                        <span id="cpas" style="color:red">{{ $errors->has('current_password') ? $errors->first('current_password') : '' }}</span>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="password">New Password</label>
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
                                                        <span style="color:red">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="password_confirmation">Confirm Password</label>
                                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                                                        <span style="color:red">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</span>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                                    </div>
                                                </form>
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
  <script>
      $(document).ready(function () {
          $("#current_password").keyup(function () {
              var current_password = $(this).val();
              $.ajax({
                  url : "{{ route('user.check.password') }}",
                  type : "get",
                  data : {current_password: current_password},

                  success:function (response) {
                      if(response.status == false){
                          $("#cpas").text('Current Password is Wrong !');
                      }else{
                          $("#cpas").text('');
                      }
                  }
              });
          });
      });
  </script>
@endpush
