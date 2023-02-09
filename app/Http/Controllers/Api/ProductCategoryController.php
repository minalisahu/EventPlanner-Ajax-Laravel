<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Product;
use Validator;

class ProductCategoryController extends BaseController
{
    public function categories()
    {
        $products = ProductCategory::active()->with('image')->take(3)->get();
        return $this->sendResponse($products, 'List of all product categories.');

    }

    public function categoryProduct(Request $request ,$id)
    { 
        $products = Product::active()->whereHas('productCategories', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();
        return $this->sendResponse($products, 'List of all product categories.');
    }
}
