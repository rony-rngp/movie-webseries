@extends('layouts.backend.app')

@section('title', 'Edit Profile')

@push('css')

@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Edit Profile</h3>
                        </div>
                        <div class="card-body">
                            <form id="quickForm" action="{{ route('admin.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{ $admin->name }}" class="form-control" placeholder="Name">
                                        <span style="color:red">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="email">E-Mail</label>
                                        <input type="email" name="email" id="email" value="{{ $admin->email }}" class="form-control" placeholder="E-Mail">
                                        <span style="color:red">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" class="form-control dropify" data-default-file="{{ $admin->image != '' && file_exists(public_path('backend/upload/admin/'.$admin->image)) ? url('backend/upload/admin/'.$admin->image) : '' }}" data-max-file-size="5M" id="image" accept="image/*">
                                        <span style="color:red">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-10">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>

                                </div>
                            </form>
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
    <script>
        $(function () {
            $('#quickForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    }

                },
                messages: {

                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
