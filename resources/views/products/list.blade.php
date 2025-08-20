<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 12 CRUD Dengan PostgreSQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3fdfb; /* hijau tosca muda background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #20c997, #0d9488); /* gradient hijau tosca */
        }

        .navbar-custom h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-custom {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-custom .card-header {
            background: linear-gradient(135deg, #20c997, #0d9488);
        }

        .card-custom .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .table th {
            background-color: #e6fffa; /* soft tosca */
        }

        .btn-primary {
            background-color: #20c997; /* hijau tosca */
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #0d9488; /* lebih gelap saat hover */
        }

        .btn-info {
            border-radius: 10px;
            background-color: #17a2b8;
            border: none;
        }

        .btn-danger {
            border-radius: 10px;
        }

        .search-box {
            border-radius: 10px;
        }

        .badge-price {
            background-color: #20c997;
            font-size: 0.9rem;
        }

        /* Lebarkan kolom Created at dan Action */
        .table th.created-col,
        .table td.created-col {
            width: 110px;
        }

        .table th.action-col,
        .table td.action-col {
            width: 130px;
        }

        /* Pagination hijau tosca */
.pagination .page-link {
    color: #20c997;
    border-radius: 10px;
    border: 1px solid #20c997;
}

.pagination .page-link:hover {
    background-color: #20c997;
    color: white;
}

.pagination .page-item.active .page-link {
    background-color: #0d9488;
    border-color: #0d9488;
    color: white;
}
 
    </style>
</head>

<body>
    <div class="navbar-custom py-3 text-center text-white shadow">
        <h3>Laravel 12 CRUD Dengan PostgreSQL</h3>
    </div>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-11 d-flex justify-content-end">
                <form method="GET" action="/products/search" class="d-flex">
                    <input class="form-control search-box me-2" name="search" placeholder="Search..."
                        value="{{ request()->input('search') ? request()->input('search') : '' }}">
                    <button type="submit" class="btn btn-success">Search</button>
                </form>
                <a href="{{ route('products.create') }}" class="btn btn-primary ms-2">+ Create</a>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
                <div class="col-md-11 mt-4">
                    <div class="alert alert-success shadow-sm">
                        {{ Session::get('success') }}
                    </div>
                </div>
            @endif
            <div class="col-md-11">
                <div class="card card-custom shadow-lg my-4">
                    <div class="card-header text-white">
                        <h3>Products</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Sku</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th class="created-col">Created at</th>
                                    <th class="action-col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->isNotEmpty())
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                @if ($product->image != "")
                                                    <img width="50" class="rounded shadow-sm"
                                                        src="{{ asset('uploads/products/'.$product->image) }}" alt="">
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td><span class="badge badge-price">${{ $product->price }}</span></td>
                                            <td>{{ $product->description }}</td>
                                            <td class="created-col">{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                                            <td class="action-col">
                                                <a href="{{ route('products.edit',$product->id) }}" class="btn btn-info btn-sm">Edit</a>
                                                <a href="#" onclick="deleteProduct({{ $product->id }});" class="btn btn-danger btn-sm">Delete</a>
                                                <form id="delete-product-from-{{ $product->id }}" action="{{ route('products.destroy',$product->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No products found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete product?")) {
                document.getElementById("delete-product-from-" + id).submit();
            }
        }
    </script>
</body>

</html>
