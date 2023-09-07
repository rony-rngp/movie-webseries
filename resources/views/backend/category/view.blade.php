@extends('layouts.backend.app')

@section('title', 'Category List')

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
                            <h3 class="float-left">Category List ({{ $categories->count() }})</h3>
                            <p class="float-right "><a class="btn btn-info btn-sm" href="{{ route('admin.category.add') }}"><i class="fa fa-plus-square"></i> Add Category</a></p>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <img width="50px" src="{{ file_exists(public_path('backend/upload/category/'.$category->image)) ? url('backend/upload/category/'.$category->image) : asset('backend/upload/no_image.png') }}">
                                        </td>
                                        <td>
                                            <input type="checkbox" data-toggle="toggle" data-size="sm" data-on="Active"  data-offstyle="danger" data-off="Inactive" id="status" data-id="{{ $category->id }}"  {{ $category->status == 1 ? 'checked' : '' }}  >
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.category.edit',$category->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="delete" type="button" onclick="deleteData({{ $category->id }})">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{ $category->id }}" action="{{ route('admin.category.destroy', $category->id) }}" method="post" style="display: none">
                                                @csrf
                                                @method('post')
                                            </form>
                                            <!--End Delete Data-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
    $(document).on('change', '#status', function () {
        var id = $(this).attr('data-id');
        if(this.checked){
            var status = 1;
        }else{
            var status = 0;
        }

        $.ajax({
            url: "{{ route('admin.category.status') }}",
            type: "get",
            data: {id : id, status : status},
            success: function (result) {
                console.log(result);
            }
        })
    });
</script>
@endpush
