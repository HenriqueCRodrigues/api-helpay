<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use Carbon\Carbon;

class DeleteTest extends TestCase
{

    private function deleteProductThroughTheApi($productId) {
        return $this->deleteJson(route('products.delete', ['productId' => $productId]));
    }

    private function checkProductDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('products', $item);
    }

    /** @test */
    public function it_delete_and_hidden_in_database() {
        Carbon::setTestNow(now());
        $product = factory(Product::class)->create();
        $this->deleteProductThroughTheApi($product->id)->assertSuccessful();
        $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()]);
    }

    /** @test */
    public function it_not_exist_in_database() {
        Carbon::setTestNow(now());
        $this->deleteProductThroughTheApi(0)->assertStatus(400);
    }

}
