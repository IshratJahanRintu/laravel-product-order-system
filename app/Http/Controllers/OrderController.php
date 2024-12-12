<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('products')->get();
        return view('orders.index', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function create()
    {

        $products = Product::where('stock_quantity', '>', 0)->get();

        return view('orders.place-order', compact('products'));
    }
    public function placeOrder(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ], [
            'products.required' => 'Please add at least one product.',
            'products.array' => 'The product list is invalid.',
            'products.*.id.required' => 'Please select a valid product.',
            'products.*.id.exists' => 'Some products no longer exist.',
            'products.*.quantity.required' => 'Please enter the quantity for each product.',
            'products.*.quantity.integer' => 'Quantity must be a whole number.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',
        ]);

        DB::beginTransaction();

        try {
            $orderTotal = 0;
            $products = [];

            foreach ($request->products as $item) {
                if ($item['quantity'] > 0) {
                    $product = Product::find($item['id']);

                    if ($product->stock_quantity < $item['quantity']) {
                        throw new Exception("Not enough stock for product: " . $product->name);
                    }

                    $product->stock_quantity -= $item['quantity'];
                    $product->save();

                    $products[] = [
                        'id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                    ];

                    $orderTotal += $product->price * $item['quantity'];
                }
            }

            if (count($products) == 0) {
                throw new Exception("Please select at least one product.");
            }

            $order = Order::create(['total_price' => $orderTotal]);

            foreach ($products as $product) {
                $order->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('orders.index')->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {

        DB::beginTransaction();

        try {

            $order = Order::findOrFail($id);
            $order->products()->detach();
            $order->delete();
            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (Exception $e) {

            DB::rollBack();
            return redirect()->route('orders.index')->with('error', $e->getMessage());
        }
    }



}
