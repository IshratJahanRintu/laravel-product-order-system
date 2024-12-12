@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Orders</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Order Date</th>
                <th>Total Products</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                @php
                    // Filter out soft deleted products
                    $validProducts = $order->products->filter(function ($product) {
                        return !$product->deleted_at;
                    });
                    $totalQuantity = $validProducts->sum('pivot.quantity');
                    $totalPrice = 0;
                    foreach ($validProducts as $product) {
                        $totalPrice += $product->pivot->quantity * $product->pivot->price;
                    }
                    $hasValidProducts = !$validProducts->isEmpty();  // Check if there are valid products
                @endphp

                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>

                    {{-- Total Products --}}
                    <td>
                        @if ($validProducts->isEmpty())
                            No valid products
                        @else
                            {{ $totalQuantity }}
                        @endif
                    </td>

                    {{-- Total Price --}}
                    <td>
                        @if ($validProducts->isEmpty())
                            No valid products
                        @else
                            ${{ number_format($totalPrice, 2) }}
                        @endif
                    </td>

                    <td>
                        @if ($hasValidProducts)
                        <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-info btn-sm "
                          >
                            View
                        </a>


                        @endif
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                       >
                                    Delete
                                </button>
                            </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No orders found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
