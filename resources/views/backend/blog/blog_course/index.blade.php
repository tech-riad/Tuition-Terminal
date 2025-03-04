@extends('layouts.app')
<link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

@section('content')

<div>
    <h3>Blog Category</h3>
</div>

@if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif

<div class="card mb-4" id="dataTable">


    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <a class="btn btn-sm btn-warning" href="">Trush List</a>
        {{-- <a class="btn btn-sm btn-primary" href="">Add New</a> --}}

        <!-- Trigger the modal with a button -->
        <a type="button" href="{{route('blog.course.create')}}" class="btn btn-sm btn-primary">Add New</a>


    </div>
    <div class="card-body">
        {{-- <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"> --}}
        <table id="datatablesSimple" class="dataTable-table">
            <thead>
                <tr>

                    <th data-sortable="" style="width: 8.6154%;"><a href="#" class="dataTable-sorter">SL</a></th>
                    <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Slider Image</a>
                    <th data-sortable="" style="width: 18.5769%;"><a href="#" class="dataTable-sorter">Course Name</a>
                    </th>
                    <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Learn
                            Description</a></th>
                    <th data-sortable="" style="width: 26.1923%"><a href="#" class="dataTable-sorter">About category</a>
                    </th>
                    <th data-sortable="" style="width: 26.1923%;"><a href="#" class="dataTable-sorter">Short
                            Description</a></th>
                    <th data-sortable="" style="width: 9.13462%;"><a href="#" class="dataTable-sorter">Action</a></th>
                    {{-- <th data-sortable="" style="width: 11.4423%;"><a href="#" class="dataTable-sorter">Salary</a></th> --}}
                </tr>
            </thead>

            <tbody>

                @foreach ($blogposts as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->slider_image)
                                @foreach(json_decode($item->slider_image) as $image)
                                    <img style="height: 30px;width:30px" src="{{ asset('storage/course-blog-images/' . $image) }}" alt="Image" class="img-thumbnail">
                                @endforeach
                            @endif
                        </td>
                        <td>{!! Str::limit($item->courses->name,100 ?? 'n/a') !!}</td>
                        <td>{!! Str::limit($item->learn_category,100 ?? 'n/a') !!}</td>
                        <td>{!! Str::limit($item->about_category_first,100 ?? 'n/a') !!}</td>
                        <td>{!! Str::limit($item->about_category_second,100 ?? 'n/a') !!}</td>
                        <td>


                            <a href="{{route('blog.course.edit',$item->id)}}"  type="button"
                                class="btn btn-warning btn-sm" >Edit</a>


                            {{-- <form id="btndelete{{$item->id}}"
                                action="{{ route('blog.item.delete', ['item' => $item->id]) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger btn-sm " id="{{$item->id}}"
                                    onclick="btnDelete(this, this.id)">Delete</button>
                            </form> --}}


                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center gap-2">

                    {{ $blogposts->appends(request()->except('page'))->links() }}

                </div>
    </div>
</div>
</div>
</div>

{{-- edit Modal --}}

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <p>Edit & Update Category</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="" method="post" action="{{route('blog.category.update')}}">
                    @csrf
                    <input class="form-control" type="hidden" id="category_id" name="category_id" value="">
                    <label style="" class="form-la">Edit Category Name</label><br>
                    <input type="text" value="" class="form-control name" name="name" id="category_name" required>
                    {{-- <p>Some text in the modal.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="btnEdit()">update</button>
            </div>

            </form>

        </div>

    </div>
</div>


{{-- end Edit Modal --}}


@push('page_scripts')
<script type="text/javascript" src="{{asset('js/dashboard/blog/category_create.js')}}"></script>
@endpush

@endsection
</html>


