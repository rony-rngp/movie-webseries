@extends('layouts.backend.app')

@section('title', 'Edit Video')

@push('css')
    {{--    <link href="{{ asset('backend/text-editor/summernote.min.css') }}" type="text/css" rel="stylesheet"/>--}}
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="{{ asset('backend/cloudinary_palyer/cld-video-player.min.css') }}" rel="stylesheet">
    <script src="{{ asset('backend/cloudinary_palyer/cloudinary-core-shrinkwrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/cloudinary_palyer/cld-video-player.min.js') }}"type="text/javascript"></script>

@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Edit Video</h3>
                            <p class="float-right "><a class="btn btn-info btn-sm" href="{{ route('admin.video.view') }}"><i class="fa fa-list-alt"></i> Video List</a></p>
                        </div>

                        <div class="card-body">
                            <form id="quickForm" action="{{ route('admin.video.update', $movie->id) }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-control select2bs4">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option {{ $movie->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">&nbsp;&nbsp;&nbsp;&raquo; &nbsp;&nbsp;{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span style="color:red">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-6" id="show_sub_category" style="display: {{ $subcategories->count() == 0 ? 'none' : ''}}">
                                        <label for="subcategory_id">Sub Category</label>
                                        <select name="subcategory_id" id="subcategory_id" class="form-control select2bs4">
                                            <option value="">Select Sub Category</option>
                                            @foreach($subcategories as $subcategory)
                                                <option {{ $movie->subcategory_id == $subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                        <span style="color:red">{{ $errors->has('subcategory_id') ? $errors->first('subcategory_id') : '' }}</span>
                                    </div>


                                    <div class="form-group col-md-6" id="show_sub_subcategory" style="display: {{ $sub_subcategories->count() == 0 ? 'none' : ''}}">
                                        <label for="sub_subcategory_id">Sub Sub Category</label>
                                        <select name="sub_subcategory_id" id="sub_subcategory_id" class="form-control select2bs4">
                                            <option value="">Select Sub Sub Category</option>
                                            @foreach($sub_subcategories as $sub_subcategory)
                                                <option {{ $movie->sub_subcategory_id == $sub_subcategory->id ? 'selected' : '' }} value="{{ $sub_subcategory->id }}">{{ $sub_subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                        <span style="color:red">{{ $errors->has('sub_subcategory_id') ? $errors->first('sub_subcategory_id') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="episode">Episode</label>
                                        <input type="text" name="episode" id="episode" value="{{ $movie->episode }}" class="form-control" placeholder="Episode">
                                        <span style="color:red">{{ $errors->has('episode') ? $errors->first('episode') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" value="{{ $movie->title }}" class="form-control" placeholder="Title">
                                        <span style="color:red">{{ $errors->has('title') ? $errors->first('title') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description">{{ $movie->description }}</textarea>
                                        <span style="color:red">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" value="" class="form-control dropify" data-default-file="{{ file_exists(public_path('backend/upload/video/'.$movie->image)) ? url('backend/upload/video/'.$movie->image) : '' }}" data-max-file-size="5M" accept="image/*">
                                        <span style="color:red">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Video ( <u><i>
                                                    @if($movie->video_status == 'Complete')
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal">Show Video</a>
                                                        @else
                                                        <a href="javascript:void(0)" style="cursor: not-allowed">Processing</a>
                                                        @endif
                                                </i></u> )
                                        </label>
                                        <input type="file" class="my-pond"  name="temp_id"/>
                                        <span class="text-danger">{{ $errors->has('temp_id') ? 'This video filed is required.' : '' }}</span>
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




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video
                        id="example-player"
                        controls
                        class="cld-video-player cld-video-player-skin-dark"
                        data-cld-public-id="{{ $movie->video_public_id }}">
                    </video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">


    <!-- add before </body> -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <!-- include FilePond jQuery adapter -->
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script>
        $(function(){

            // Turn input element into a pond
            $('.my-pond').filepond();

            // Register the plugin
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            // Set allowMultiple property to true
            $('.my-pond').filepond('allowMultiple', false);

            FilePond.create(document.querySelector(".my-pond"), {
                name: 'temp_id',
                acceptedFileTypes: ['video/*'],
                fileValidateTypeDetectType: (source, type) =>
                    new Promise((resolve, reject) => {
                        // Do custom type detection here and return with promise
                        resolve(type);
                    }),
            });

            FilePond.setOptions({

                server: {
                    url: '{{ route('admin.video.upload') }}',

                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

        });

    </script>

    <!-- cloudinary show video </body> -->
    <script>
        var cld = cloudinary.Cloudinary.new({ cloud_name: 'rony-islam' });
        var player = cld.videoPlayer('example-player');
    </script>


    {{--    <script src="{{ asset('backend/text-editor/summernote.min.js') }}"></script>--}}
    <script>
        $(document).ready(function() {
            $('#description').summernote();
        });
    </script>

    <script>
        //get subcategory
        $(document).ready(function () {
            //get subcategory
            $(document).on('change', '#category_id', function () {
                var category_id = $(this).val();
                $.ajax({
                    url : "{{ route('admin.video.subcategory') }}",
                    type : 'get',
                    data : {category_id:category_id},

                    success:function (res) {
                        if(res.status == true){
                            $("#show_sub_category").show();
                            $("#show_sub_subcategory").hide();
                            $("#sub_subcategory_id").text('');
                            var html = '<option value="">Select Sub Category</option>';
                            $.each(res.sub_categories, function (key, v) {
                                html +='<option value="'+v.id+'">'+v.name+'</option>';
                            });
                            $('#subcategory_id').html(html);
                        }else{
                            $("#show_sub_category").hide();
                            $("#subcategory_id").text('');
                            $("#show_sub_subcategory").hide();
                            $("#sub_subcategory_id").text('');
                        }

                    }
                });
            });

            //get sub sub-category
            $(document).on('change', '#subcategory_id', function () {
                var subcategory_id = $(this).val();
                $.ajax({
                    url : "{{ route('admin.video.sub_subcategory') }}",
                    type : 'get',
                    data : {subcategory_id:subcategory_id},

                    success:function (res) {
                        if(res.status == true){
                            $("#show_sub_subcategory").show();
                            var html = '<option value="">Select Sub Sub Category</option>';
                            $.each(res.sub_subcategories, function (key, v) {
                                html +='<option value="'+v.id+'">'+v.name+'</option>';
                            });
                            $('#sub_subcategory_id').html(html);
                        }else{
                            $("#show_sub_subcategory").hide();
                            $("#sub_subcategory_id").text('');
                        }


                    }
                });
            });

        });


        $(function () {
            $('#quickForm').validate({
                rules: {
                    category_id : {
                        required: true,
                    },
                    subcategory_id: {
                        required: true,
                    },
                    sub_subcategory_id: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    description: {
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
