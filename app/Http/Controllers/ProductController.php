<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            "data" => $products,
            "message" => "success"
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "data" => null,
                "message" => "error"
            ]);
        }

        return response()->json([
            "data" => $product,
            "message" => "success"
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "data" => null,
                "message" => "error"
            ], 404);
        }

        $product->delete();

        return response()->json([
            "data" => null,
            "message" => "deleted successfully"
        ], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => "required|string|min:2",
            'desc' => "required|string|max:20000",
            'price' => "required|numeric",
            'image' => "required|image|mimes:png,jpg,jpeg,gif,webp",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed, handle errors
            $errors = $validator->errors();
           return response()->json($errors,422);
            // e.g., return back with errors: return back()->withErrors($errors);
        } 
            // Validation passed, proceed with data
         $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
    $request->image->move(public_path('uploads/products'), $imageName);
    $data=$request->all();

$data['image']=$imageName;
$product = Product::create($data);

 return response()->json($product,201);
       // dd($request->all());
    }
    public function update($id,Request $request){
     $product = Product::find($id);
   $rules = [
            'name' => "required|string|min:2",
            'desc' => "required|string|max:20000",
            'price' => "required|numeric",
            'image' => "sometimes|image|mimes:png,jpg,jpeg,gif,webp",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed, handle errors
            $errors = $validator->errors();
           return response()->json($errors,422);
            // e.g., return back with errors: return back()->withErrors($errors);
        } 
         $data=$request->all();

        if($request->image){
         $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
    $request->image->move(public_path('uploads/products'), $imageName);
    $data['image']=$imageName;   
        }else{
            $data['image']=$product->image;
        }
        $product->update($data);
         return response()->json($product,202);
    }
}
