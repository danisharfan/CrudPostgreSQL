<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 12 CRUD Dengan PostgreSQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3fdfb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #20c997, #0d9488);
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

        .form-label {
            color: #0d9488;
            font-weight: 600;
        }

        .form-control,
        .form-control-lg,
        textarea {
            border-radius: 10px;
            border: 1px solid #b2dfdb;
            box-shadow: none;
        }

        .form-control:focus,
        .form-control-lg:focus,
        textarea:focus {
            border-color: #20c997;
            box-shadow: 0 0 5px rgba(32, 201, 151, 0.5);
        }

        .btn-primary {
            background-color: #20c997;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #0d9488;
        }

        .btn-outline-primary {
            border-color: #20c997;
            color: #20c997;
            border-radius: 10px;
        }

        .btn-outline-primary:hover {
            background-color: #20c997;
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
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">← Back</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card card-custom shadow-lg my-4">
                    <div class="card-header text-white">
                        <h3>Create Product</h3>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('products.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label h5">Name</label>
                                <input value="{{ old('name') }}" type="text" 
                                       class="@error('name') is-invalid @enderror form-control form-control-lg" 
                                       placeholder="Name" name="name">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label h5">Sku</label>
                                <input value="{{ old('sku') }}" type="text" 
                                       class="@error('sku') is-invalid @enderror form-control form-control-lg" 
                                       placeholder="Sku" name="sku">
                                @error('sku')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label h5">Price</label>
                                <input value="{{ old('price') }}" type="text" 
                                       class="@error('price') is-invalid @enderror form-control form-control-lg" 
                                       placeholder="Price" name="price">
                                @error('price')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label h5">Description</label>
                                <textarea placeholder="Description" 
                                          class="form-control form-control-lg" 
                                          name="description" cols="30" rows="5">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label h5">Image</label>
                                <input type="file" class="form-control form-control-lg" name="image">
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
