<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $sales = Sale::with('product')->where('user_id', $user)->get();
        $products = Stock::with('product')->get();

        return view('sales-rep.index', compact(
            'products',
            'sales'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id.*' => 'required',
            'quantity.*' => 'required|numeric',
            'price.*' => 'required|numeric',
        ]);

        $trans_id = mt_rand(111111111, 999999999);

        foreach ($data['product_id'] as $key => $productId) {
            $quantity = $data['quantity'][$key];
            $price = $data['price'][$key];

            // Calculate the total amount (price * quantity)
            $total = $price * $quantity;

            Sale::create([
                'user_id' => Auth::user()->id,
                'trans_id' => $trans_id, $key,
                'product_id' => $productId,
                'quantity' => $data['quantity'][$key],
                'amount' => $total,
                'status' => 0,
            ]);

            // Deduct the sold quantity from Stock
            $stock = Stock::where('product_id', $productId)->first();
            if ($stock) {
                $newQuantity = $stock->quantity - $quantity;
                $stock->update(['quantity' => $newQuantity]);
            } else {
                return redirect()->back()->with('message', 'Item not found.')->with('type', 'error');
            }
        }

        return redirect()->back()->with('message', 'Sales successfully recorded.')->with('type', 'success');
    }

    public function stock()
    {
        $stock = Stock::all();
        return view('sales-rep.stock', [
            'stock' => $stock
        ]);
    }

    public function getStockQuantity($productId)
    {
        $stock = Stock::where('product_id', $productId)->first();

        if ($stock) {
            return response()->json([
                'quantity' => $stock->quantity
            ]);
        }

        return response()->json([
            'quantity' => 0
        ]);
    }
}
