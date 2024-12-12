@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #6ab04c;">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">{{ $categoryCount }} Categories</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-light">View Categories</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #487eb0;">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">{{ $productCount }} Products</p>
                        <a href="{{ route('products.index') }}" class="btn btn-light">View Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #e1b12c;">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text">{{ $orderCount }} Orders</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-light">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white" style="background-color: #e84118;">
                    <div class="card-body">
                        <h5 class="card-title">Place Order</h5>
                        <p class="card-text">Create a New Order</p>
                        <a href="{{ route('orders.create') }}" class="btn btn-light">Place an Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
