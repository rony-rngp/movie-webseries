@extends('layouts.backend.app')

@section('title', 'Edit Sub Sub-Category')

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
                            <h3 class="float-left">Edit Sub Sub-Category</h3>
                            <p class="float-right "><a class="btn btn-info btn-sm" href="{{ route('admin.sub_subcategory.view') }}"><i class="fa fa-list-alt"></i> Sub Sub-Category List</a></p>
                        </div>

                        <div class="card-body">
                            <form id="quickForm" action="{{ route('admin.sub_subcategory.update', $sub_subcategory->id) }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label for="subcategory_id">Sub Category</label>
                                        <select name="subcategory_id" id="subcategory_id" class="form-control select2bs4">
                                            <option value="">Select Sub Category</option>
                                            @foreach($categories as $category)
                                                <optgroup label="{{ $category->name }}"></optgroup>
                                                @foreach($category->subcategories as $subcategory)
                                                    <option {{ $sub_subcategory->subcategory->id == $subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">&nbsp;&nbsp;&nbsp;&raquo; &nbsp;&nbsp;{{ $subcategory->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <span style="color:red">{{ $errors->has('subcategory_id') ? $errors->first('subcategory_id') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{ $sub_subcategory->name }}" class="form-control" placeholder="Name">
                                        <span style="color:red">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
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
