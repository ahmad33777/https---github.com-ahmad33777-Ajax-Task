@extends('layouts.mainlayout')
@section('header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">category Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="div mb-2">
        <div class="container">
            <div class="col-8"></div>
            <input type="text" class="form-control" id="search" name="search" placeholder="Enter name to search">
        </div>
    </div>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addeModal">
        create
    </button>
    <br>
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Categories </h3>
        </div>
        <!-- /.card-header -->

        <div class="card-body table-responsive p-0">
            <table id="tableID" class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Parent category </th>
                        <th>Description</th>
                        <th>status</th>
                        <th>image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="allData">
                    @foreach ($categoreis as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->parent->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @if ($category->status == 'active')
                                    <span class="badge bg-success">{{ $category->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $category->status }}</span>
                                @endif

                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $category->image) }}" width="30" alt="testImage">
                            </td>
                            <td>
                                {{-- <a href="" id="updateBtn" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#updateeModal" data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}" data-description="{{ $category->description }}"
                                    data-status="{{ $category->status }}">Edit</a> --}}

                                <button type="button" id="editBtn" value="{{ $category->id }}"
                                    class="btn btn-sm btn-primary">
                                    Edit
                                </button>
                                <a href="#" class="btn btn-danger btn-sm" id="deleteId"
                                    data-id="{{ $category->id }}"><i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody id="content" class="searchData">

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="addCategoryForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter category name ">
                            </div>

                            <span style="color: red" id="name_err" class="errr"></span>

                            <hr>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
                            </div>

                            <span style="color: red" class="errr" id="description_err"> </span>


                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status" value="active"
                                    @checked(old('status') == 'active')>
                                <label class="form-check-label">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status"
                                    value="archived" @checked(old('status') == 'archived')>
                                Archived
                                </label>
                            </div>


                            <hr>
                            <div class="form-group">
                                <label for="description">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <span style="color: red" class="errr" id="image_err"></span>
                            <br>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary submit">Save </button>
                </div>
            </div>
        </div>
    </div>


    {{-- Update Modal --}}
    <div class="modal fade" id="updateeModal" tabindex="-1" aria-labelledby="updateeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateeModal">Update Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="updateCategoryForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="up_id">
                        <div class="card-body">
                            {{-- name --}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="up_name" id="up_name" class="form-control"
                                    placeholder="Enter category name ">
                            </div>
                            <span style="color: red" id="up_name_err" class="up_err"></span>

                            <hr>
                            {{-- Description --}}
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="up_description" id="up_description" cols="30" rows="4" class="form-control"></textarea>
                            </div>

                            <span style="color: red" class="up_err" id="up_description_err"> </span>


                            <hr>
                            {{-- Status --}}
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="up_status" id="up_status_active"
                                    value="active">
                                <label class="form-check-label">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="up_status" id="up_status_archived"
                                    value="archived">
                                Archived
                                </label>
                            </div>


                            <hr>
                            {{-- Image --}}
                            <div class="form-group">
                                <label for="description">Image</label>
                                <input type="file" name="up_image" id="up_image" class="form-control">
                            </div>
                            <span style="color: red" class="up_err" id="up_image_err"></span>
                            <br>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submit_update" class="btn btn-primary submit_update">Update </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Add new Catagory By Ajax --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.submit', function(event) {
                event.preventDefault();
                var form_data = new FormData(document.getElementById("addCategoryForm"));
                $.ajax({
                    url: "{{ route('categories.store') }}",
                    type: 'POST',
                    data: form_data,
                    beforeSend: function() {
                        $(document).find('.errr').text('');
                    },
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(res) {
                        console.log(res);
                        if (res.status == 'success') {
                            $("#addeModal").modal('hide');
                            $('#addCategoryForm')[0].reset();
                            toastr.success('successfully saved')
                            $("#tableID").load(location.href + " #tableID")

                        }
                    },
                    error: function(xhr, status, errors) {
                        // let error = errors.responseJSON;
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessagesHtml = '<ul>';
                            $.each(errors, function(field, messages) {
                                // Display validation error messages next to the input fields
                                $('#' + field + '_err').html(messages.join('<br>'));
                                errorMessagesHtml += '<li>' + messages + '</li>';
                            });
                            errorMessagesHtml += '</ul>';
                            toastr.options = {
                                closeButton: false,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 3000,

                            };
                            toastr.error(errorMessagesHtml);
                        } else {
                            // Handle other types of errors, e.g., display a generic error message
                            toastr.error('The operation failed ');

                        }
                    }
                    // show errors
                    // error: function(error) {
                    //     if (error.responseJSON && error.responseJSON.errors) {
                    //         var errors = error.responseJSON.errors;
                    //         var errorMessagesHtml = '<ul>';
                    //         for (var key in errors) {
                    //             if (errors.hasOwnProperty(key)) {
                    //                 $('#' + field + '_err').text(errors[key][0])
                    //                 errorMessagesHtml += '<li>' + errors[key][0] + '</li>';
                    //             }
                    //         }
                    //         errorMessagesHtml += '</ul>';
                    //         toastr.error(errorMessagesHtml);

                    //     } else {
                    //         toastr.error('An error occurred. Please try again.');
                    //     }
                    // }

                });
            });

        });
    </script>

    {{-- show cdata --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#editBtn', function() {
                var category_id = $(this).val();
                console.log(category_id);
                $('#updateeModal').modal('show');
                $.ajax({
                    type: 'get',
                    url: 'categories/' + category_id + '/edit',
                    success: function(response) {
                        console.log(response);
                        let category = response.category;
                        $('#up_id').val(category.id);
                        $('#up_name').val(category.name);
                        $('#up_description').val(category.description);
                        if (category.status == 'active') {
                            $('#up_status_active').prop('checked', true);
                        } else if (category.status == 'archived') {
                            $('#up_status_archived').prop('checked', true);
                        } else {
                            $('#up_status_draft').prop('checked', true);
                        }
                    }
                });
            });
        });
    </script>


    {{-- Update data form --}}
    <script>
        $(document).ready(function() {
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#submit_update', function(event) {
                event.preventDefault();

                let id = $('#up_id').val();
                let name = $('#up_name').val();
                let description = $('#up_description').val();
                var status = $('input[name="up_status"]:checked').val();
                let image = $('#up_image')[0].files[0];

                let formData = new FormData();
                formData.append('id', id);
                formData.append('name', name);
                formData.append('description', description);
                formData.append('status', status);
                formData.append('image', image);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('categories.update') }}', // Change this URL to match your Laravel route
                    data: formData,
                    beforeSend: function() {
                        $(document).find('.error').text('');
                    },
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response.status == 'success') {
                            $("#updateeModal").modal('hide');
                            toastr.success('Update completed successfully')
                            $("#tableID").load(location.href + " #tableID")

                        } else if (response.status == 'error') {
                            toastr.error('Update completed successfully')

                        }
                    },
                    error: function(error) {
                        if (error.responseJSON && error.responseJSON.errors) {
                            var errors = error.responseJSON.errors;
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    toastr.error(errors[key][0]);
                                }
                            }
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        // update Catagory
        // $(document).on('click', '#submit_update', function(event) {
        //     event.preventDefault();
        //     var form_data = new FormData(document.getElementById("updateCategoryForm"));
        //     console.log(form_data);
        //     $.ajax({
        //         url: "{{ route('categories.update') }}",
        //         type: 'POST',
        //         // data: form_data,
        //         data: $('#updateCategoryForm').serialize(),
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         beforeSend: function() {
        //             $(document).find('.up_err').text('');
        //         },
        //         dataType: "JSON",
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function(res) {
        //             if (res.status == 'success') {
        //                 $("#updateeModal").modal('hide');
        //                 $('#updateCategoryForm')[0].reset();
        //                 toastr.success('successfully Updated');
        //                 $("#tableID").load(location.href + " #tableID");
        //             }
        //         },
        //         // show errors
        //         error: function(errors) {
        //             let error = errors.responseJSON;
        //             $.each(error.errors, function(index, value) {
        //                 $('#' + index + '_err').text(value);
        //             })
        //         }

        //     });
        // });








        // delete 
        $(document).on('click', '#deleteId', function(event) {
            event.preventDefault();
            let category_id = $(this).data('id');
            // Swal.fire('Any fool can use a computer')
            swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete the category?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('categories.destroy') }}",
                        type: 'post',
                        data: {
                            category_id: category_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                $("#tableID").load(location.href + " #tableID");
                            }
                        },
                    });

                    swal.fire('Deleted successfully', 'The action was successfully completed.', 'success');
                } else {
                    // User clicked "Cancel" or closed the dialog
                    swal.fire('Cancelled', 'The action was cancelled.', 'info');
                }
            });


        });



        $('#search').on('keyup', function() {
            let value = $(this).val();
            if (value) {
                $('#allData').hide();
                $('.searchData').show();
            } else {
                $('#allData').show();
                $('.searchData').hide();
            }

            $.ajax({
                type: 'get',
                url: "{{ route('categories.search') }}",
                data: {
                    'search': value
                },
                success: function(data) {
                    console.log(data);
                    $('#content').html(data);
                },
            })

        });
    </script>
@endsection
{{-- // show Category dtat in model 
// $(document).on('click', '#updateBtn', function() {
//     let id = $(this).data('id');
//     let name = $(this).data('name');
//     let description = $(this).data('description');
//     let status = $(this).data('status');

//     $('#up_id').val(id);
//     $('#up_name').val(name);
//     $('#up_description').val(description);
//     if (status == 'active' ?? false) {
//         $('#up_status_active').prop('checked', true);
//     } else {
//         $('#up_status_archived').prop('checked', true);
//     }
// }); --}}
