<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ShowTest extends TestCase
{

    private function showProductThroughTheApi($productId) {
        return $this->getJson(route('products.show', ['productId' => $productId]));
    }

    private function checkProductDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('products', $item);
    }

    /** @test */
    public function it_show_and_exist_in_database() {
        Carbon::setTestNow(now());
        $product = factory(Product::class)->create();
        $this->showProductThroughTheApi($product->id)->assertSuccessful();
        $this->checkProductDatabaseHas($product, ['created_at' => now(), 'updated_at' => now()]);
    }

    /** @test */
    public function it_not_exist_in_database() {
        Carbon::setTestNow(now());
        $this->showProductThroughTheApi(0)->assertStatus(400);
    }

}
