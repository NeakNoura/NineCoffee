
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">
                        {{ Session::get('success') }}                
                    </p>
                @endif  
                
                <h5 class="card-title mb-3">Create Product</h5>

                <form action="{{ route('store.products')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" name="price" class="form-control" id="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" id="image" required>
                    </div>
                    <div class="form-group">
                        <label for="exarmpleFormControlTextarea1">Description</label>
                        <textarea name="description" class="form-control" id="exarmpleFormControlTextarea1" cols="30" rows="10"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Product Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="type">Type</option>
                            <option value="drinks">Drinks</option>
                            <option value="desserts">Desserts</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                    <a href="{{ route('all.products') }}" class="btn btn-danger">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




