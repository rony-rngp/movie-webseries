@extends('layouts.backend.app')

@section('title', 'Edit Sub Category')

@push('css')

@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Edit Sub Category</h3>
                            <p class="float-right "><a class="btn btn-info btn-sm" href="{{ route('admin.subcategory.view') }}"><i class="fa fa-list-alt"></i> Sub Category List</a></p>
                        </div>

                        <div class="card-body">
                            <form id="quickForm" action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="category_id">Root Category</label>
                                        <select name="category_id" id="category_id" class="form-control select2bs4">
                                            @foreach($categories as $category)
                                                <option {{ $subcategory->category->id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span style="color:red">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{ $subcategory->name }}" class="form-control" placeholder="Name">
                                        <span style="color:red">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" class="form-control dropify" data-default-file="{{ file_exists(public_path('backend/upload/subcategory/'.$subcategory->image)) ? url('backend/upload/subcategory/'.$subcategory->image) : '' }}" data-max-file-size="5M" id="image" accept="image/*">
                                        <span style="color:red">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- ./col -->
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
