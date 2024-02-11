<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rep;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function products()
    {
        $products = Product::all();
        return view('admin.products', [
            'products' => $products
        ]);
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'product_type' => 'required|in:whole,piece',
            'name' => 'required|string',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'status' => 'required|in:active,inactive',
        ]);

        $product = new Product($data);
        $product->save();

        return response()->json([
            'message' => 'Product added successfully'
        ]);
    }

    public function productStock(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
        ]);

        $existingStock = Stock::where('product_id', $data['product_id'])->first();

        if ($existingStock) {
            $existingStock->increment('quantity', $data['quantity']);
        } else {
            $stock = new Stock($data);
            $stock->save();
        }

        return response()->json([
            'message' => 'Product added to stock successfully'
        ]);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('admin.products')->with('message', 'Product deleted successfully')->with('type', 'success');
        }

        return redirect()->route('admin.products')->with('message', 'Product not found')->with('type', 'warning');
    }

    public function deleteStock($id)
    {
        $stock = Stock::find($id);

        if ($stock) {
            $stock->delete();
            return redirect()->route('admin.stock')->with('message', 'Product removed from stock successfully')->with('type', 'success');
        }

        return redirect()->route('admin.stock')->with('message', 'Product not found')->with('type', 'warning');
    }

    public function stock()
    {
        $stock = Stock::all();
        return view('admin.stock', [
            'stock' => $stock
        ]);
    }

    public function rep()
    {
        $rep = User::where('role', 'rep')->get();
        return view('admin.rep', [
            'rep' => $rep
        ]);
    }
}
