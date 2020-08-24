<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    
    public function store($data) {
        try {
            \DB::beginTransaction();
            $product = Product::create($data);
            \DB::commit();

            return ['message' => $product, 'status' => 200];
        } catch (\Exception $e) {
            \DB::rollback();
            return ['message' => $e->getMessage(), 'status' => 500];
        }
    }

    public function list($data) {
        try {
            \DB::beginTransaction();
            $product = Product::paginate();

            return ['message' => $product, 'status' => 200];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }  
    }

    public function show($productId) {
        try {
            $product = Product::find($productId);
            if ($product) {
                return ['message' => $product, 'status' => 200];
            }

            return ['message' => 'Erro nos dados enviado', 'status' => 400];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }
    }

    public function delete($productId) {
        try {
            \DB::beginTransaction();

            $product = Product::find($productId);
            if ($product) {
                if ($product->delete()) {
                    \DB::commit();
                    return ['message' => 'Produto excluído', 'status' => 200];
                }

                return ['message' => 'Erro interno no servidor', 'status' => 500];
            }

            return ['message' => 'Erro nos dados enviado', 'status' => 400];
        } catch (\Exception $e) {
            \DB::rollback();
            return ['message' => $e->getMessage(), 'status' => 500];
        }
    }
}
