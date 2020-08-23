<?php

namespace Tests\Feature\Order;

use Tests\TestCase;
use App\Models\Order;
use App\Services\GoogleApiService;
use Carbon\Carbon;

class StoreTest extends TestCase
{

    private function storeOrderThroughTheApi($order = null) {
        $order = $order ?? collect([]);
        return $this->postJson(route('orders.store'), $order->toArray());
    }

    private function unitInputApi($input, $meta = null) {
        Carbon::setTestNow(now());


        $merge = [];

        $merge[$input] = $meta;
        if ($meta) {
            $meta = explode(':', $meta);
            if ($meta[0] == 'less') {
                $order = factory(Order::class)->make();

                $meta = explode(',', $meta[1]);
                $info = json_decode(json_encode(\DB::table($meta[0])->where('id', $order->product_id)->first()), TRUE)[$meta[1]]+10;
                $order[$input] = $info;
                $merge = $order->toArray();
            }
        }

        $order = factory(Order::class)->make($merge);

        $this->storeOrderThroughTheApi($order)
        ->assertStatus(422);
    }

    /** @test */
    public function it_should_store_in_database() {
        Carbon::setTestNow(now());
        $order = factory(Order::class)->make();
        $store = $this->storeOrderThroughTheApi($order);
        
        //Descomentar a linha abaixo para deletar o arquivo no drive
        /*
        $googleApiService = new GoogleApiService();
        $googleApiService->deleteFile($store->json()['data']['id_file_drive']);
        */
        $store->assertSuccessful();
    }
    
    /** @test */
    public function product_id_input_field_is_required() {
        $this->unitInputApi('product_id');
    }

    /** @test */
    public function quantity_purchased_input_field_is_required() {
        $this->unitInputApi('quantity_purchased');
    }

    /** @test */
    public function quantity_purchased_input_field_is_less_than_product_stock() {
        $this->unitInputApi('quantity_purchased', 'less:products,qty_stock');
    }

    /** @test */
    public function card_number_input_field_is_required() {
        $this->unitInputApi('card_number');
    }

    /** @test */
    public function card_number_input_field_is_integer() {
        $this->unitInputApi('card_number', 'string');
    }

    /** @test */
    public function card_number_input_field_is_valid_number() {
        $this->unitInputApi('card_number', '0539524042353483');
    }

    /** @test */
    public function date_expiration_input_field_is_required() {
        $this->unitInputApi('date_expiration');
    }

    /** @test */
    public function date_expiration_input_field_is_date_format_month_Year() {
        $this->unitInputApi('date_expiration', '01/01/2020');
    }

    /** @test */
    public function flag_input_field_is_required() {
        $this->unitInputApi('flag');
    }

    /** @test */
    public function cvv_input_field_is_required() {
        $this->unitInputApi('cvv');
    }

    public function qty_stock_input_field_is_integer() {
        $this->unitInputApi('qty_stock', 'string');
    }
}
