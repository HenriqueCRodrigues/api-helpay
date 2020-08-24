<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\GenericResponse;
use App\Http\Requests\OrderRequest;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }
    
    public function store(OrderRequest $request) {
        $response = $this->orderRepository->store($request->all());
        return GenericResponse::response($response);
    }
}
