@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="container mt-4">
        <h1>Order Details</h1>

        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title">Order :{{ $order->id }}</h5>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Total Products:</strong> {{ $order->products->sum('pivot.quantity') }}</p>
                <p><strong>Total Price:</strong> ${{ number_format($order->products->sum('pivot.quantity') * $order->products->sum('price'), 2) }}</p>
            </div>
        </div>

        <h4>Products</h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
    </div>
@endsection
