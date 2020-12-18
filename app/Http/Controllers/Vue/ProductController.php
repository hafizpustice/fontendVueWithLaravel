<?php

namespace App\Http\Controllers\Vue;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Validator\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    protected $apiResponse;
    protected $rules = array(
        'title' => 'required|unique:products',
        'description' => 'required',
        'price' => 'required',
        'image' => 'required',
    );

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
        //dd($request->all());
        $data = $this->validate($request, $this->rules);

        //$validator = Validator::make($request->all(), $this->rules);

        // if ($validator->fails()) {
        //     dd($validator->messages()->all());
        // } else {
        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
        ]);
        // Session::flash('message', 'Created Successfully.');
        return $this->apiResponse->responseApiWithSuccess('Product created successfully', null);
        //}
    }

    public function show($id)
    {
        $product = Product::whereId($id)->get();
        if (!$product->isEmpty()) {
            return $this->apiResponse->responseApiWithSuccess('Product get successfully', $product);
        } else {
            return $this->apiResponse->responseApiWithSuccess('No Product found ', []);
        }

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        $this->rules = collect($this->rules)->merge([
            'title' => 'required|unique:products,title' . ($product->id ? ",$product->id" : ''),
        ])->toArray();

        $data = $this->validate($request, $this->rules);

        if (array_key_exists('errors', $data)) {
            return $this->apiResponse->responseApiWithError('The given data was invalid', $data['errors']);
        }

        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->image = $data['image'];

        $product->save();
        return $this->apiResponse->responseApiWithSuccess('Product updated successfully', $data);

    }

    public function destroy($id)
    {
        $data = Product::whereId($id)->delete();
        if ($data) {
            return $this->apiResponse->responseApiWithSuccess('Product Deleted successfully', []);
        }
        return $this->apiResponse->responseApiWithSuccess('No Product Found', []);

    }
}
