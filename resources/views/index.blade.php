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
            margin-left: 60px;
            padding: 10px 20px 10px 20px;
        }
        .btn-dark {
            color: #fff;
            background-color: #343a40;
            border-color: #343a40;
        }
        .table-wrapper {
            overflow-x: auto; 
            max-height: 500px; 
        }
        .table-wrapper table {
            width: 100%; 
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #fff; 
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product List</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="GET" action="{{ route('product.search') }}">
            <div class="custom-search-container">
                <input type="text" name="query" class="custom-search-input" placeholder="Search by name...">
                <input type="number" name="minPrice" class="custom-search-input" placeholder="Min Price">
                <input type="number" name="maxPrice" class="custom-search-input" placeholder="Max Price">
                <button type="submit" class="custom-search-button"><i class="fas fa-search"></i></button>
                <a href="/create" class="btn btn-dark product-btn"><i class="fas fa-plus"></i></a>
            </div>
        </form>
        <form id="bulkDeleteForm" method="POST" action="{{ route('product.bulkDelete') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Bulk Delete</button>
            <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th><a href="{{ route('product.index', ['sort_by' => 'name', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Name</a></th>
                        <th><a href="{{ route('product.index', ['sort_by' => 'description', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Description</a></th>
                        <th><a href="{{ route('product.index', ['sort_by' => 'price', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Price</a></th>
                        <th>Image</th>
                        <th>History</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><input type="checkbox" name="selected_products[]" value="{{ $product->id }}"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td><img src="{{ asset('img/' . $product->image) }}" alt="Image" width="50"></td>
                            <td><a href="{{ route('product.history', $product->id) }}" class="btn btn-dark">History</a></td>
                            <td>
                                <div style="display: flex;">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm custom-edit-button">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('product.delete', $product->id) }}" method="POST" class="d-inline">
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
                </tbody>
            </table>
        </div>
        </form>
        {{ $products->appends(request()->query())->links() }}
    </div>
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        $(document).ready(function() {
            $('#bulkDeleteForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>

@endsection
