<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * 
     * @group create_product
     */
    public function create_product()
    {
        // With description
        $product1 = Product::create([
            'name' => 'Test Product 1',
            'description' => 'This is a test product 1 description.',
            'price' => 1.00,
        ]);
        $this->assertDatabaseHas('products', ['id' => $product1->id, 'name' => $product1->name]);
        
        // Without description
        $product2 = Product::create([
            'name' => 'Test Product 2',
            'price' => 22.22,
        ]);
        $this->assertDatabaseHas('products', ['id' => $product2->id, 'name' => $product2->name]);
    }

    /**
     * @test
     * 
     * @group update_product
     */
    public function update_product()
    {
        $old_name = 'Original Product';
        $old_price = 9.99;
        $product = Product::create([
            'name' => $old_name,
            'description' => 'Original description',
            'price' => $old_price,
        ]);

        $new_name  = 'Updated Product';
        $new_price = 1.11;
        $product->update([
            'name' => $new_name,
            'price' => $new_price,
        ]);

        $this->assertDatabaseMissing('products', ['name' => $old_name, 'price' => $old_price]);
        $this->assertDatabaseHas('products', ['name' => $new_name, 'price' => $new_price]);
    }

    /**
     * @test
     * 
     * @group delete_product
     */
    public function delete_product()
    {
        $product = Product::create([
            'name' => 'To Be Deleted',
            'description' => 'This product will be deleted.',
            'price' => 7.99,
        ]);

        $product->delete();

        $this->assertDatabaseMissing('products', ['id' => $product->id, 'name' => $product->name]);
    }
}
