<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StoreTest extends TestCase
{

    private function storeProductThroughTheApi(Product $product = null) {
        $product = $product ?? collect([]);
        return $this->postJson(route('products.store'), $product->toArray());
    }

    private function checkProductDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('products', $item);
    }

    private function checkProductDatabaseMissing($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseMissing('products', $item);
    }

    private function unitInputApi($input, $meta = null) {
        Carbon::setTestNow(now());


        $merge = [];

        $merge[$input] = $meta;
        if ($meta) {
            $meta = explode(':', $meta);
            if ($meta[0] == 'max') {
                if ($input == 'file') {
                    $merge[$input] = ['type' => 'max', 'size' => $meta[1]];
                } else {
                    $merge[$input] = Str::random($meta[1]+1);
                }
            } else if ($meta[0] == 'exists') {
                $meta[1] = explode(',', $meta[1]);
                return $this->assertDatabaseMissing($meta[1][0], [$meta[1][1] => '']);
            } else if ($meta[0] == 'unique') {
                $product = factory(Product::class)->create();
                $merge = [$input => $product->email];
            } else if ($meta[0] == 'mimes') {
                if ($input == 'file') {
                    $merge[$input] = ['type' => 'mime', 'extension' => $meta[1]];
                }
            }
        }

        $product = factory(Product::class)->make($merge);

        $this->storeProductThroughTheApi($product, $merge)
        ->assertStatus(422);
        
        $merge['created_at'] = now(); 
        $merge['updated_at'] = now();
        $this->checkProductDatabaseMissing($product, $merge);
    }

    /** @test */
    public function it_should_store_in_database() {
        Carbon::setTestNow(now());
        $product = factory(Product::class)->make();
        $this->storeProductThroughTheApi($product)->assertSuccessful();
        $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now()]);
    }
    
    /** @test */
    public function name_input_field_is_required() {
        $this->unitInputApi('name');
    }

    /** @test */
    public function amount_input_field_is_required() {
        $this->unitInputApi('amount');
    }

     /** @test */
     public function amount_input_field_is_numeric() {
        $this->unitInputApi('amount', 'string');
    }

    /** @test */
    public function qty_stock_input_field_is_required() {
        $this->unitInputApi('qty_stock');
    }

    /** @test */
    public function qty_stock_input_field_is_integer() {
        $this->unitInputApi('qty_stock', 'string');
    }
}
