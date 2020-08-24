<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\GenericResponse;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }
    
    public function store(ProductRequest $request) {
        $response = $this->productRepository->store($request->all());
        return GenericResponse::response($response);
    }

    public function list(Request $request) {
        $response = $this->productRepository->list($request);
        return GenericResponse::response($response);
    }

    public function show($productId) {
        $response = $this->productRepository->show($productId);
        return GenericResponse::response($response);
    }

    public function delete($productId) {
        $response = $this->productRepository->delete($productId);
        return GenericResponse::response($response);
    }
}
