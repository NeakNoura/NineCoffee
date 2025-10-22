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
                        
                    @if (Session::has('delete'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                        {{ Session::get('delete') }}                
                    </p>
                @endif
                    <h5 class="card-title mb-3 d-inline">All Products</h5>
                    <a href="{{route('create.products')}}" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Type</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->name }}</td>
                                <td><img src="{{asset('assets/images/'.$product->image.'')}}" width="50" ></td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->type }}</td>                               
                                <td><a href="{{ route('delete.products', $product->id)}}" class="btn btn-danger text-center">Delete</a></td>
                                <td>
                                    <a href="{{ route('edit.products', $product->id) }}" class="btn btn-warning text-center">Edit</a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>                  
                
            </div>
        </div>
    </div>
</div>
@endsection



