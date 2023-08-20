<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::paginate(10);
        return view('product.index')->with([
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:5'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'string', 'in:active,archived'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $name = $request->input('name');
        $description = $request->input('description');
        $category_id = $request->input('category_id');
        $status = $request->input('status');
        $price = $request->input('price');

        $product->name = $name;
        $product->slug = Str::slug($name);
        $product->description = $description;
        $product->status = $status;
        $product->price = $price;
        $product->category_id = $category_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uplodes/images/', [
                'disk' => 'public'
            ]);
            $product->image = $path;
        }


        $product->save();
        return response()->json([
            'status' => 'success'
        ]);
    }


    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:5'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'string', 'in:active,archived'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'image' => 'nullable', // Adjust mime types and size limit as needed
        ]);

        $id = $request->input('id');
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->slug = $request->input('name');
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');

        $oldeImage = $product->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uplodes/images/', [
                'disk' => 'public'
            ]);
            $product->image = $path;
            Storage::disk('public')->delete($oldeImage);
        }

        $status = $product->save();
        if ($status) {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }


    }

    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }



    public function search(Request $request)
    {
        $search = $request->serach_value;
        $products = Product::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')->get();

        if($products->count() >=1){

        }else{
            
        }
    }
}