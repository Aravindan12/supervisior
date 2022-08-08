<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Jobs\StoreMailJob;
use App\Jobs\UpdateMailJob;
use App\Jobs\ProductJob;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class ProductController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id= Auth::id();
        $products = Product::where('user_id',$user_id)->paginate(10);
      
        return view('products.index',compact('products','user_id'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id= Auth::id();
        return view('products.create',compact('user_id'));
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
        ]);
      
        $user_id = $request->user_id;
        $user= User::find($user_id);
        $product_name=$request->product_name;
        $price = $request->price;
        $unique_id = $request->unique_id;
        Product::create([
            'user_id'=>$user_id,
            'product_name'=>$product_name,
            'price'=>$price,
            'unique_id'=> $unique_id
        ]);
        // dd(1);dd
        $job = new StoreMailJob($user,$product_name,$price);
        dispatch($job);
       
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }
  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $user = Auth::user();
        if($user->can('view', $product)){
            $user_id= Auth::id();
            return view('products.show',compact('product','user_id'));
        }
        else{
            return redirect()->route('products.index');
        }
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        Log::info("Log is working");
        $user = Auth::user();
        if($user->can('update', $product)){
            $user_id= Auth::id();
            
        return view('products.edit',compact('product','user_id'));
        }
        else{
          
            return redirect()->route('products.index');
        }
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
        ]);
        $user_id = $request->user_id;
        $user= User::find($user_id);
        $product_name=$request->product_name;
        $slug_name = \Str::slug($product_name);
        $unique_id = 'Pr'.$product->id;
        $price = $request->price;
        $product->update([
            'user_id'=>$user_id,
            'product_name'=>$product_name,
            'slug_name'=>$slug_name,
            'price'=>$price,
            'unique_id'=>$unique_id
        ]);
       
        $job = new UpdateMailJob($user,$product_name,$price);
        dispatch($job);
      
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
       
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
    }
