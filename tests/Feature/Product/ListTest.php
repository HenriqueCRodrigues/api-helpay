<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use Carbon\Carbon;

class ListTest extends TestCase
{

    private function listProductThroughTheApi() {
        return $this->getJson(route('products.list'));
    }

    private function checkProductDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('products', $item);
    }

    /** @test */
    public function it_list_and_exist_in_database() {
        Carbon::setTestNow(now());
        $products = factory(Product::class, 20)->create();
        $this->listProductThroughTheApi()->assertSuccessful();
        
        foreach($products as $product) {
            $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now()]);
        }
    }

}
