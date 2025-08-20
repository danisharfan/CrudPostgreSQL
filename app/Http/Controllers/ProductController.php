<?php
 
namespace App\Http\Controllers;
 
use App\Models\Product; //php artisan make:model Product -m 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
 
class ProductController extends Controller
{
    public function index() {
        //$products = Product::paginate(2); https://laravel.com/docs/11.x/pagination
        $products = Product::orderBy('created_at', 'DESC')->paginate(3);
        //$products = Product::orderBy('created_at','DESC')->get(); 
 
        return view('products.list',[
            'products' => $products
        ]);
         
    }
 
    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
 
            $products = Product::where(
                'name',
                'like',
                "$search%"
            )
                ->orWhere('sku', 'like', "$search%")
                ->paginate(2);
 
            return view('products.list', compact('products'));
        }
 
        $products = DB::table('products')
        ->orderBy('id', 'DESC')
        ->paginate(5);
        return view('products.list', compact('products'));
    }
 
    public function create() {
        return view('products.create');
    }
 
    public function store(Request $request) {
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric'           
        ];
 
        if ($request->image != "") {
            $rules['image'] = 'image';
        }
 
        $validator = Validator::make($request->all(),$rules);
 
        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
 
        // insert product
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
 
        if ($request->image != "") {
            // store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // Unique image name
 
            // Save image to products directory
            $image->move(public_path('uploads/products'),$imageName);
 
            // Save image name
            $product->image = $imageName;
            $product->save();
        }        
 
        return redirect()->route('products.index')->with('success','Product added successfully.');
    }
 
    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }
 
    public function update($id, Request $request) {
 
        $product = Product::findOrFail($id);
 
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric'           
        ];
 
        if ($request->image != "") {
            $rules['image'] = 'image';
        }
 
        $validator = Validator::make($request->all(),$rules);
 
        if ($validator->fails()) {
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }
 
        // update product
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
 
        if ($request->image != "") {
 
            // delete old image
            File::delete(public_path('uploads/products/'.$product->image));
 
            // store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // Unique image name
 
            // Save image to products directory
            $image->move(public_path('uploads/products'),$imageName);
 
            // Save image name
            $product->image = $imageName;
            $product->save();
        }        
 
        return redirect()->route('products.index')->with('success','Product updated successfully.');
    }
 
    public function destroy($id) {
        $product = Product::findOrFail($id);
 
       // delete image
       File::delete(public_path('uploads/products/'.$product->image));
 
       // delete product
       $product->delete();
 
       return redirect()->route('products.index')->with('success','Product deleted successfully.');
    }
}