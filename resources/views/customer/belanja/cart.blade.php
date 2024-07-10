@extends('layout/layout')
@section('space-work')

<div class="container">
        <h1>Your Cart</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (count($cart) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0;
                        $totalItems = 0;
                    @endphp
                    @foreach ($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $totalPrice += $subtotal;
                            $totalItems += $item['quantity'];
                        @endphp
                        <tr>
                            <td><img src="{{ asset('image/'.$item['photo']) }}" alt="{{ $item['name'] }}" style="max-width: 100px;"></td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $subtotal }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-item-form">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td><strong>Total Items:</strong> {{ $totalItems }}</td>
                        <td><strong>Total Price:</strong> {{ $totalPrice }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.remove-item-form');
            forms.forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    if (confirm('Are you sure you want to remove this item from the cart?')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection