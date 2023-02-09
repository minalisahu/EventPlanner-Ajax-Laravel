<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Tinkeshwar\Imager\Imager;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::active()->get();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        if ( $product= Product::create($data)) {
            if ($request->hasfile('image')) {
                foreach ($request->file('image') as $image) {
                    $product->images()->create([
                        'name'=>Imager::moveFile($image,'public'), //second parameter is optional, `public` is default
                        'path'=>'public/', //sample path used in above function
                        'driver' => config('image.image_storage')
                    ]);
                }
            }
            $product->productCategories()->sync($data['categories']);

         
            return redirect()->route('product.list')->with('success_message', __('Product was successfully added.'));
        }
        return back()->withInput()->with('error_message', __('Unexpected error occurred while trying to process your request.')); 
    }

     /**
     * Change status of the specified resource.
     *
     * @param id, token
     *
     * @return Illuminate\View\View
     */
    public function status(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->update(['status' => ($product->status == 'Active' ? 0 : 1)]);
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::active()->get();
        return view('products.edit',compact('product','categories'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($product->update($data)) {
            if ($request->hasfile('image')) {
                foreach ($request->file('image') as $image) {
                    $product->images()->create([
                        'name'=>Imager::moveFile($image,'public'), //second parameter is optional, `public` is default
                        'path'=>'public/', //sample path used in above function
                        'driver' => config('image.image_storage')
                    ]);
                }
            }
            $product->productCategories()->sync($data['categories']);
            return redirect()->route('product.list')->with('success_message', __('Product was successfully updated.'));
        }
        return back()->withInput()->with('error_message', __('Unexpected error occurred while trying to process your request.'));
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
    if ($product->delete()) {
        return redirect()->route('product.list')->with('success_message', __('Product was successfully deleted.'));
    }
    return back()->withInput()->with('error_message', __('Unexpected error occurred while trying to process your request.'));  
    }

    
    public function image_destroy($image)
    {
        return Imager::deleteFile($image);
    }
}