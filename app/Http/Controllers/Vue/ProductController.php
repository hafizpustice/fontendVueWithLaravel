<?php

namespace App\Http\Controllers\Vue;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Validator\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        if ($request->is('wedevs/*')) { //for api request response
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return $this->apiResponse->responseApiWithError('product list get successfully', $validator->messages()->all());
            } else {
                $fileName = Str::random(25) . '_123_' . $request['image']->getClientOriginalName();
                request()->image->move(public_path('storage/product'), $fileName);
                $path = 'storage/product/' . $fileName;
                Product::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'price' => $request->price,
                    'image' => $path,
                ]);
            }
            return $this->apiResponse->responseApiWithSuccess('product save successfully', []);
        }

        //fpor web httpp request
        $data = $this->validate($request, $this->rules);
        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
        ]);
        return $this->apiResponse->responseApiWithSuccess('Product created successfully', null);
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
            'image' => 'nullable',
        ])->toArray();

        if ($request->is('wedevs/*')) { //for api request response
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return $this->apiResponse->responseApiWithError('Invalid from data', $validator->messages()->all());
            } else {
                if ($request->file('image')) {
                    $fileName = Str::random(25) . '_123_' . $request['image']->getClientOriginalName();
                    request()->image->move(public_path('storage/product'), $fileName);
                    $path = 'storage/product/' . $fileName;
                }else{
                    $path = $product->image;
                }
                $product->title = $request->title;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->image = $request->title;
                $product->save();
            }
            return $this->apiResponse->responseApiWithSuccess('product updated successfully', []);
        }
        //foe web http request
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
