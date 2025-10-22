@extends('layouts.admin')

@section('content')
<div class="main">
    <h1>Admin Dashboard</h1>

    <!-- Recent Orders -->
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Recent Orders</h2>
            <a href="{{ route('all.orders') }}" class="btn">View All</a>
        </div>

        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Payment</td>
                    <td>Status</td>
                </tr>
            </thead>

            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td>{{ $order->product_name }}</td>
                    <td>${{ $order->price }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>
                        <span class="status {{ strtolower($order->status) }}">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No recent orders</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
