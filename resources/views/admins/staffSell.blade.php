@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <section class="staff-sell-section card p-4">
            <h2 class="text-center mb-4">Staff Sell POS</h2>

            <!-- Product List -->
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-2 text-center mb-3">
                        <div class="product-card" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                            <img src="{{ asset('assets/images/'.$product->image) }}" class="img-fluid rounded mb-2" style="height:120px; object-fit:cover;">
                            <div>{{ $product->name }}</div>
                            <div>${{ $product->price }}</div>
                            <button type="button" class="btn btn-sm btn-success add-to-cart">+</button>
                            <button type="button" class="btn btn-sm btn-danger remove-from-cart">-</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cart Table -->
            <h4 class="mt-4">Cart</h4>
            <table class="table table-sm" id="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Cart items will appear here -->
                </tbody>
            </table>

            <!-- Checkout Form -->
            <form id="checkout-form" action="{{ route('staff.checkout') }}" method="POST">
                @csrf
                <input type="hidden" name="cart_data" id="cart_data">
                <button id="checkout" class="btn btn-sm btn-primary">Checkout</button>
            </form>

        </section>
    </div>
</div>

<script>
let cart = {}; // store cart items

// Add to cart
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const card = this.closest('.product-card');
        const id = card.dataset.id;
        const name = card.dataset.name;
        const price = parseFloat(card.dataset.price);

        if(cart[id]) {
            cart[id].quantity++;
        } else {
            cart[id] = { name, price, quantity: 1 };
        }

        renderCart();
    });
});

// Remove from cart
document.querySelectorAll('.remove-from-cart').forEach(button => {
    button.addEventListener('click', function() {
        const card = this.closest('.product-card');
        const id = card.dataset.id;

        if(cart[id]) {
            cart[id].quantity--;
            if(cart[id].quantity <= 0) delete cart[id];
        }

        renderCart();
    });
});

// Render cart table
function renderCart() {
    const tbody = document.querySelector('#cart-table tbody');
    tbody.innerHTML = '';

    Object.keys(cart).forEach(id => {
        const item = cart[id];
        tbody.innerHTML += `<tr>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>$${(item.price * item.quantity).toFixed(2)}</td>
        </tr>`;
    });
}

// Handle checkout
document.querySelector('#checkout').addEventListener('click', function(e) {
    e.preventDefault(); // prevent default form submission

    if(Object.keys(cart).length === 0){
        alert("Cart is empty!");
        return;
    }

    const cartDataInput = document.querySelector('#cart_data');
    cartDataInput.value = JSON.stringify(cart); // send all items as JSON

    document.querySelector('#checkout-form').submit(); // submit form once
});
</script>

@endsection
