<?php

namespace App\Repositories;

use App\Models\Product;
use App\Services\GoogleApiService;
use SimpleXMLElement;

class OrderRepository
{
    protected $googleApiService;
    
    public function __construct()
    {
        $this->googleApiService = new GoogleApiService();
    }

    public function store($data) {
        $uploaded = null;

        try {

            \DB::beginTransaction();
            $xml = new SimpleXMLElement('<dados/>');
            foreach($data as $key => $value) {
                if (is_array($value)) {
                    $card = $xml->addChild($key);
                    foreach($value[0] as $key => $info) {
                        $card->addChild($key, $info);
                    }
                } else {
                    $xml->addChild($key, $value);
                }
            }

            $uploaded = $this->googleApiService->driveUpload($xml->asXML(), 'xml', 'text/xml');
            if ($uploaded['status'] == 200) {
                $product = Product::find($data['product_id']);
                if ($product->update(['qty_stock' => ($product->qty_stock-$data['quantity_purchased'])])) {
                    \DB::commit();
                    return ['message' => ['message' => 'Pedido realizado.', 'id_file_drive' => $uploaded['id_file']], 'status' => 200];
                }
            } 

            if (isset($uploaded['id_file'])) {
                $this->googleApiService->deleteFile($uploaded['id_file']);
            }
            
            return ['message' => 'Erro nos dados enviado', 'status' => 400];
        } catch (\Exception $e) {
            \DB::rollback();
            if (isset($uploaded['id_file'])) {
                $this->googleApiService->deleteFile($uploaded['id_file']);
            }
            return ['message' => $e->getMessage(), 'status' => 500];
        }
    }
}
