@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Staff Checkout</h2>

    @if(empty($cart))
        <p class="text-center">Your cart is empty.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <h4>Total: <strong>${{ number_format($total, 2) }}</strong></h4>
        </div>

        <hr>

        {{-- ABA Payment Section --}}
        <div class="text-center mt-4">
            <h5>Scan to Pay with ABA</h5>
            <p>Use your ABA app to scan this QR and complete the payment.</p>

            <!-- ✅ Make sure your image file is inside: public/assets/images/image.png -->
            <img src="{{ asset('assets/images/image.png') }}" alt="ABA QR" width="200" class="border p-2 rounded">

            <div class="mt-2">
                <a href="https://pay.ababank.com/oRF8/6qxitpv7" target="_blank" class="btn btn-primary mt-3">
                    Open in ABA App
                </a>
            </div>
        </div>

        <hr>

        {{-- PayPal Section --}}
        <div class="text-center mt-4">
            <h5>Or Pay with PayPal</h5>
            <form action="{{ route('admin.paypal') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-success btn-lg mt-2">
                    Pay Now with PayPal
                </button>
            </form>
        </div>

    @endif
</div>
@endsection
