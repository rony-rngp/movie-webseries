@extends('layouts.backend.app')

@section('title', 'Add CMS')

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
                            <h3 class="float-left">Add CMS</h3>
                            <p class="float-right "><a class="btn btn-info btn-sm" href="{{ route('admin.cms.view') }}"><i class="fa fa-list-alt"></i> CMS List</a></p>
                        </div>

                        <div class="card-body">
                            <form id="quickForm" action="{{ route('admin.cms.store') }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Title" >
                                        <span style="color:red">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                        <span style="color:red">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" id="meta_description" name="meta_description"  placeholder="Meta Description" >{{ old('meta_description') }}</textarea>
                                        <span style="color:red">{{ $errors->has('meta_description') ? $errors->first('meta_description') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="meta_keyword">Meta Keyword</label>
                                        <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" value="{{ old('meta_keyword') }}" placeholder="Meta Keyword" >
                                        <span style="color:red">{{ $errors->has('meta_keyword') ? $errors->first('meta_keyword') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).ready(function() {
            $('#description').summernote();
        });
    </script>

    <script>
        $(function () {
            $('#quickForm').validate({
                rules: {
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    meta_description: {
                        required: true,
                    },
                    meta_keyword: {
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
