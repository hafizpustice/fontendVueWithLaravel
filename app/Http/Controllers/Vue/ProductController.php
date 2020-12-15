<?php

namespace App\Http\Controllers\Vue;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Validator\ApiResponse;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $apiResponse;
    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }
    public function index()
    {
        $products = Product::all();
        //dd('ok');
        return response()->json([
            'product' =>$products
        ]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
