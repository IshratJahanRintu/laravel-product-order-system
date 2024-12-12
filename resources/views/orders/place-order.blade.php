@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center text-success">Place Your Order</h2>

        @if($products->isEmpty())
            <div class="alert alert-info text-center">
                No products available to place an order.
            </div>
        @else
            <form action="{{ route('orders.place') }}" method="POST">
                @csrf

                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card border-success shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                </div>
                                <div class="card-body bg-light">
                                    <p class="card-text text-muted">Description: {{ $product->description ?? 'No description available.' }}</p>
                                    <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                                    <p class="card-text"><strong>Stock:</strong> {{ $product->stock_quantity }} available</p>

                                    <div class="form-group mt-3">
                                        <label for="quantity_{{ $product->id }}">Quantity</label>
                                        <input type="number"
                                               name="products[{{ $product->id }}][quantity]"
                                               id="quantity_{{ $product->id }}"
                                               class="form-control"
                                               min="1"
                                               max="{{ $product->stock_quantity }}"
                                               value="1"
                                               required>
                                    </div>

                                    <input type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group mt-4 text-center">
                    <button type="submit" class="btn btn-success btn-lg">Place Order</button>
                </div>
            </form>
        @endif
    </div>
@endsection
