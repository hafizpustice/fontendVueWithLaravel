<?php

namespace App\Http\Controllers\Vue;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Validator\ApiResponse;
use Illuminate\Http\Request;

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
        return $this->apiResponse->responseApiWithSuccess('get Product data', $products);
    }

    public function create()
    {
        
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