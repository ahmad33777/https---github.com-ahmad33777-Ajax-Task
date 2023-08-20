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
                        <li class="breadcrumb-item active">Products Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_product_Modal">
        create
    </button>
    <br>
    <br>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Products </h3>
        </div>
        <br>
        <div class="div mb-2">
            <div class="container">
                <div class="col-8"></div>
                <input type="text" class="form-control" id="search" name="search"
                    placeholder="sname , price or description  to search">
            </div>
        </div>
        <div class="card-body table-responsive p-0 table-data">
            <table id="tableID" class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>product Name</th>
                        <th>category Name</th>
                        <th>Description</th>
                        <th>status</th>
                        <th>price</th>
                        <th>image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="allData">
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? null }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                @if ($product->status == 'active')
                                    <span class="badge bg-success">{{ $product->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $product->status }}</span>
                                @endif
                            </td>
                            <td>{{ $product->price }} -$</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" width="50px" alt="product_image">
                            </td>
                            <td>
                                <button type="button" id="editBtn" value="{{ $product->id }}"
                                    class="btn btn-sm btn-primary">
                                    Edit
                                </button>

                                <a href="" id="deleteID" data-id="{{ $product->id }}"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
                {{-- <tbody id="content" class="searchData">
                </tbody> --}}
            </table>
            <br>

            {!! $products->links() !!}
        </div>

    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_product_Modal" tabindex="-1" aria-hidden="true">
        <div id="errorContainer"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create new Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="add_product_from" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            {{-- name products --}}
                            <div class="form-group">
                                <label for="name">Product Name </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter product name ">
                            </div>

                            <span style="color: red" id="name_err" class="error"></span>
                            <hr>
                            {{-- Description  --}}
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <span style="color: red" id="description_err" class="error"></span>
                            <hr>

                            <select style="color: blue" class="form-select form-select-lg mb-3"
                                aria-label="Large select example" id="category_id" name="category_id">
                                <option selected disabled>choose an appropriate category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name ?? null }}</option>
                                @endforeach
                            </select>
                            <span style="color: red" id="category_id_err" class="error"></span>
                            <hr>
                            {{-- start status  --}}
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status" value="active">
                                <label class="form-check-label">
                                    Active
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status"
                                    value="archived">
                                Archived
                                </label>
                            </div>
                            {{-- end  status  --}}
                            <hr>
                            {{-- start price --}}
                            <div class="form-group">
                                <label for="price">Product price </label>
                                <input type="number" name="price" id="price" min="1" class="form-control"
                                    placeholder="Enter product price ">
                            </div>
                            <span style="color: red" id="price_err" class="error"></span>
                            {{-- end price --}}
                            <hr>

                            {{-- start image  --}}
                            <div class="form-group">
                                <label for="description">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <hr>
                            {{-- <div class="form-group">
                                <label for="description">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <span style="color: red" class="error" id="image_err"></span> --}}
                            <br>
                            {{-- end  image  --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary submit">Save </button>
                    {{-- <button type="submit" id="submit" class="btn btn-primary submit">Save </button> --}}
                </div>
            </div>
        </div>
    </div>


    {{-- edit Model  --}}

    <div class="modal fade" id="edit_product_Modal" tabindex="-1" aria-hidden="true">
        <div id="errorContainer"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit_product_from" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="up_product_id" id="up_product_id">
                        <div class="card-body">
                            {{-- name products --}}
                            <div class="form-group">
                                <label for="name">Product Name </label>
                                <input type="text" name="up_name" id="up_name" class="form-control"
                                    placeholder="Enter product name ">
                            </div>

                            <span style="color: red" id="up_name_err" class="error"></span>
                            <hr>
                            {{-- Description  --}}
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="up_description" id="up_description" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <span style="color: red" id="up_description_err" class="error"></span>
                            <hr>

                            <select style="color: blue" class="form-select form-select-lg mb-3"
                                aria-label="Large select example" id="up_category_id" name="up_category_id">
                                <option selected disabled>choose an appropriate category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name ?? null }}</option>
                                @endforeach
                            </select>
                            <span style="color: red" id="up_category_id_err" class="error"></span>
                            <hr>
                            {{-- start status  --}}
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
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="up_status" id="up_status_draft"
                                    value="draft">
                                Draft
                                </label>
                            </div>
                            {{-- end  status  --}}
                            <hr>
                            {{-- start price --}}
                            <div class="form-group">
                                <label for="price">Product price </label>
                                <input type="number" name="up_price" id="up_price" min="1"
                                    class="form-control" placeholder="Enter product price ">
                            </div>
                            <span style="color: red" id="up_price_err" class="error"></span>
                            {{-- end price --}}
                            <hr>

                            {{-- start image  --}}
                            <div class="form-group">
                                <label for="description">Image</label>
                                <input type="file" name="up_image" id="up_image" class="form-control">
                            </div>
                            <span style="color: red" class="error" id="up_image_err"></span>
                            <br>
                            {{-- end  image  --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="edit_submit" class="btn btn-primary edit_submit">Save </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



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
                // read data fro form
                var name = $('#name').val();
                var description = $('#description').val();
                var category_id = $('#category_id').val();
                var status = $('#status').val();
                var price = $('#price').val();
                var image = $('#image')[0].files[0];
                var formData = new FormData();
                formData.append('name', name);
                formData.append('description', description);
                formData.append('category_id', category_id);
                formData.append('status', status);
                formData.append('price', price);
                formData.append('image', image);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.store') }}', // Change this URL to match your Laravel route
                    data: formData,
                    beforeSend: function() {
                        $(document).find('.error').text('');
                    },
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        console.log('good');
                        if (response.status == 'success') {
                            $("#add_product_Modal").modal('hide');
                            $('#add_product_from')[0].reset();
                            toastr.success('successfully saved')
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




        // Delete Products By ID 
        $(document).on('click', '#deleteID', function(event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var product_id = $(this).data('id');
            swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete the Product ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('products.destroy') }}",
                        type: 'post',
                        data: {
                            product_id: product_id
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
    </script>


    {{-- show model with data to edit   --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#editBtn', function() {
                var product_id = $(this).val();
                // alert(schedule_id);
                console.log(product_id);
                $('#edit_product_Modal').modal('show');
                $.ajax({
                    type: 'get',
                    url: 'products/' + product_id + '/edit',
                    success: function(response) {
                        let product = response.product;
                        $('#up_product_id').val(product.id);
                        $('#up_name').val(product.name);
                        $('#up_description').val(product.description);
                        $('#up_price').val(product.price);
                        $('#up_category_id').val(product.category_id);
                        $('#up_status').val(product.status);
                        if (product.status == 'active') {
                            $('#up_status_active').prop('checked', true);
                        } else if (product.status == 'archived') {
                            $('#up_status_archived').prop('checked', true);
                        } else {
                            $('#up_status_draft').prop('checked', true);
                        }
                    }
                });
            });
        });
    </script>

    {{-- update function  --}}
    <script>
        $(document).ready(function() {
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#edit_submit', function(event) {
                event.preventDefault();

                let id = $('#up_product_id').val();
                let name = $('#up_name').val();
                let description = $('#up_description').val();
                let category_id = $('#up_category_id').val();
                var status = $('input[name="up_status"]:checked').val();
                let price = $('#up_price').val();
                let image = $('#up_image')[0].files[0];
                let formData = new FormData();
                formData.append('id', id);
                formData.append('name', name);
                formData.append('description', description);
                formData.append('category_id', category_id);
                formData.append('status', status);
                formData.append('price', price);
                formData.append('image', image);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.update') }}', // Change this URL to match your Laravel route
                    data: formData,
                    beforeSend: function() {
                        $(document).find('.error').text('');
                    },
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response.status == 'success') {
                            $("#edit_product_Modal").modal('hide');
                            toastr.success('Update completed successfully')
                            $("#tableID").load(location.href + " #tableID")

                        } else if (response.status == 'error') {
                            toastr.error('Update completed successfully')

                        }
                    },
                    error: function(xhr, status, errors) {
                        let error = errors.responseJSON;
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                // Display validation error messages next to the input fields
                                $('#' + 'up_' + field + '_err').html(messages.join(
                                    '<br>'));
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
    <script>
        $(document).on('keyup', function(event) {
            event.preventDefault();
            let serach_value = $('#search').val();
            // console.log(serach_value);
            $.ajax({
                url: "{{ route('products.search') }}",
                method: 'GET',
                data: {
                    search_data: serach_value
                },
                success: function(res) {
                    $('.table-data').html(res);
                },
                error: function(err) {

                },

            });
        });
    </script>
@en