@extends('layouts.admin-leyout')

@section('content')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <style>
        .custom-edit-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            margin-right: 5px;
        }

        .custom-trash-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .custom-trash-button:hover {
            background-color: #c82333;
        }

        .custom-trash-button:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5);
        }

        .custom-search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-search-input {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 300px;
            margin-right: 10px;
        }

        .custom-search-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .custom-search-button:hover {
            background-color: #0056b3;
        }

        .product-btn {
            margin-right: 15px;
        }

        .btn-dark {
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
            box-shadow: none;
            padding: 10px 20px;
            margin-bottom: 18px;
            margin-right: 0px;
        }

        .filter-section {
            display: none;
        }

        .filter-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: salmon;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 440px;
            margin-top: -17px;
        }

        .filter-button i {
            margin-right: 8px;
        }

        .filter-button:hover {
            background-color: peru;
        }

        .ser-btn {
            margin-left: 180px;
        }

        .filter-section {
            width: 420px;
            margin-left: 500px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .form-group{
            margin: 20px;
        }

        #filterForm{
            margin-top: -25px;
        }
    </style>
</head>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Products</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        
                        
                        <a href="{{route('mobile.create')}}" class="btn btn-dark product-btn">New Product</a>
                    </div>

                    
                    <form  method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Mobile name</th>
                                        <th style="width:20%">Mobile Description</th>
                                        <th style="width:15%">Price</th>
                                        <th style="width:25%">Image</th>
                                        <th style="width:15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($mobiles))
                                    @foreach ($mobiles as $mobile)
                                    <tr>
                                        <td>{{$mobile->name}}</td>
                                        <td>{{$mobile->description}}</td>
                                        <td>${{$mobile->price}}</td>
                                        <td>
                                            <img src="{{ asset('img') }}/{{ $mobile->image }}" class="rounded-circle" width="50" height="50" alt="Product Image">
                                        </td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="{{ route('mobile.edit', $mobile->id) }}" class="btn btn-sm custom-edit-button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('mobile.delete', $mobile->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm custom-trash-button" onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            
                        </div>
                        <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">Delete Selected</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('.select-item');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    function confirmBulkDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-form').submit();
            }
        });
    }

    $(document).ready(function() {
        $('#toggle-filter-section').click(function() {
            $('#filter-section').toggle();
        });

        $('#filterForm').submit(function(e) {
            e.preventDefault();
            var minPrice = $('#minPrice').val();
            var maxPrice = $('#maxPrice').val();
            
            window.location.href = "{{ route('product.search') }}?minPrice=" + minPrice + "&maxPrice=" + maxPrice;
        });
    });
</script>

@endsection
