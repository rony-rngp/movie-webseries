@extends('layouts.backend.app')

@section('title', 'Profile')

@push('css')

@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-md-6 offset-3">
                    <div class="card">
                        <div class="card-header ">
                            <h3 class="text-center ">Admin Profile</h3>
                        </div>

                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img" src="{{ $admin->image != '' && file_exists('backend/upload/admin/'. $admin->image) ? url('backend/upload/admin/'. $admin->image) :  url('backend//dist/img/user2-160x160.jpg') }}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $admin->name }}</h3>

                            <table class="table  table-bordered">
                                <tbody>

                                <tr>
                                    <td>Name</td>

                                    <td>{{ $admin->name }}</td>
                                </tr>

                                <tr>
                                    <td>E-Mail</td>

                                    <td>{{ $admin->email }}</td>
                                </tr>

                                </tbody>
                            </table><br>

                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

@endsection

@push('js')

@endpush
