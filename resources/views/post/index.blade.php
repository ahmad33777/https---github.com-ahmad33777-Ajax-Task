@extends('layouts.mainlayout')
@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Posts Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add_Post_Modal">
        create
    </button>
    <br>
    <br>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Posts </h3>
        </div>
        <br>
        <div class="div mb-2">
            <div class="container">
                <div class="col-8"></div>
                <input type="text" class="form-control" id="search" name="search" placeholder=" titel or content ">
            </div>
        </div>
        <div class="card-body table-responsive p-0 table-data">
            <table id="tableID" class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Post Titel</th>
                        <th>Content</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="allData">
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->content }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <button type="button" id="editBtn" value="" class="btn btn-sm btn-primary">
                                    Edit
                                </button>

                                <a href="" id="deleteID" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                {{-- <tbody id="content" class="searchData">
                </tbody> --}}
            </table>
            <br>

            {{-- {!! $products->links() !!} --}}
        </div>

    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="Add_Post_Modal">
        <div id="errorContainer"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5">Create new Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="add_post_from">
                        @csrf
                        <div class="card-body">
                            {{-- Post titel --}}
                            <div class="form-group">
                                <label for="title">Post Title </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter Post title ">
                            </div>

                            <span style="color: red" id="title_err" class="error"></span>
                            <hr>
                            {{-- Post Content   --}}
                            <div class="form-group">
                                <label for="content">Post content </label>
                                <input type="text" name="content" id="content" class="form-control"
                                    placeholder="Enter Post content ">
                            </div>

                            <span style="color: red" id="content_err" class="error"></span>

                            <hr>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary submit">Crate post </button>
                </div>
            </div>
        </div>
    </div>


    {{-- edit Model  --}}
    <div class="modal fade" id="Add_Post_Modal">
        <div id="errorContainer"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5">Edit post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit_post_from">
                        @csrf
                        <div class="card-body">
                            {{-- Post titel --}}
                            <div class="form-group">
                                <label for="title">Post Title </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter Post title ">
                            </div>

                            <span style="color: red" id="title_err" class="error"></span>
                            <hr>
                            {{-- Post Content   --}}
                            <div class="form-group">
                                <label for="content">Post content </label>
                                <input type="text" name="content" id="content" class="form-control"
                                    placeholder="Enter Post content ">
                            </div>

                            <span style="color: red" id="content_err" class="error"></span>

                            <hr>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary submit">Crate post </button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- add new Post --}}
    <script>
        $(document).ready(function() {
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.submit', function(event) {
                event.preventDefault();
                var title = $('#title').val();
                var content = $('#content').val();
                console.log(title);
                console.log(content);
                // let data = $("add_post_from").serialize();
                //  console.log(data);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('posts.store') }}', // Change this URL to match your Laravel route
                    data: {
                        "title": title,
                        "content": content
                    },
                    beforeSend: function() {
                        $(document).find('.error').text('');
                    },
                    success: function(response) {
                        console.log('good');
                        if (response.status == 'success') {
                            $("#Add_Post_Modal").modal('hide');
                            $('#add_post_from')[0].reset();
                            toastr.success('Post created successfully')
                            $("#tableID").load(location.href + " #tableID")

                        }
                    },
                    error: function(xhr, status, errors) {
                        // let error = errors.responseJSON;
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                // Display validation error messages next to the input fields
                                $('#' + field + '_err').html(messages.join('<br>'));
                                // price_err
                                // console.log(field);
                            });
                        } else {
                            // Handle other types of errors, e.g., display a generic error message
                            toastr.error('The operation failed ');

                        }
                    }
                });
            });
        });
    </script>


    {{-- show edit form --}}
    <script>

    </script>
@endsection
