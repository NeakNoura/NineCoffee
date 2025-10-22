@extends('layouts.admin')

@section('content')
<div class="container mt-5"> <!-- Adds space from top/header -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Orders</h4>
        </div>
        <div class="card-body">
            {{-- Flash Messages --}}
            @if (Session::has('update'))
                <div class="alert alert-success">
                    {{ Session::get('update') }}                
                </div>
            @endif
            @if (Session::has('delete'))
                <div class="alert alert-danger">
                    {{ Session::get('delete') }}                
                </div>
            @endif

            {{-- Orders Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Phone</th>
                            <th>Street Address</th>
                            <th>Total Price</th>                                       
                            <th>Status</th>
                            <th>Change Status</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allOrders as $order)
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ $order->first_name }}</td>
                            <td>{{ $order->last_name }}</td>
                            <td>{{ $order->city }}</td>
                            <td>{{ $order->state }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->address }}</td>
                            <td>${{ $order->price }}</td>
                            <td>
                                <span class="badge 
                                    {{ $order->status == 'Pending' ? 'badge-warning' : '' }}
                                    {{ $order->status == 'Delivered' ? 'badge-success' : '' }}
                                    {{ $order->status == 'Cancelled' ? 'badge-danger' : '' }}
                                ">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('edit.orders', $order->id) }}" class="btn btn-sm btn-info">Change Status</a>
                            </td>   
                            <td>                                
                                <form action="{{ route('delete.orders', $order->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> {{-- table-responsive --}}
        </div> {{-- card-body --}}
    </div> {{-- card --}}
</div> {{-- container --}}
@endsection
