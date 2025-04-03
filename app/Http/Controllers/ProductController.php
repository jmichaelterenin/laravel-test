<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{

    public function __construct() 
    {        
        if (!Storage::exists(Product::getTableName())) {
            Storage::put(Product::getTableName(), json_encode([]));
            $this->productsJson = [];
        } else {
            $this->productsJson = Storage::json(Product::getTableName());            
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products', ['products' => (!empty($this->productsJson) ? Product::hydrate($this->productsJson) : [])]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        \Log::info($request->all());
        $productData = array_merge($request->all(), ['created_at' => Carbon::now()]);
        $product = Product::make($productData);
        \Log::info($this->productsJson);
        array_push($this->productsJson, $product);
        Storage::put(Product::getTableName(), json_encode($this->productsJson));
        \Log::info($product->toArray());
        return $product->toJson();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
