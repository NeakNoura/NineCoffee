@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mt-4">
            <div class="card-header">
                <h4>Edit Product</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('update.products', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="price">Price ($)</label>
                        <input type="number" name="price" value="{{ $product->price }}" step="0.01" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="type">Type</label>
                        <input type="text" name="type" value="{{ $product->type }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Product Image</label><br>
                        <img src="{{ asset('assets/images/' . $product->image) }}" width="100" class="mb-2">
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('all.products') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
