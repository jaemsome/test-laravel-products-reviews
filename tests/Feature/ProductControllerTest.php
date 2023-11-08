<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function createProduct()
    {
        $product = Product::factory()->count(1)->create();
        $product = $product->shift();
        return $product;
    }

    /**
     * @test
     * 
     * @group get_product_list
     * 
     */
    public function get_products_list()
    {
        $response = $this->get(route('api-getProductsList'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'products' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                    ],
                ],
            ]);
    }

    /**
     * @test
     * 
     * @group get_product
     */
    public function get_product()
    {
        $product = $this->createProduct();

        $response = $this->get(route('api-getProduct', ['id' => $product->id]));

        $response->assertStatus(200)
            ->assertJson([
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                ],
            ]);
    }

    /**
     * @test
     * 
     * @group create_product
     */
    public function create_product()
    {
        $request = [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 10.99,
        ];

        $response = $this->post(route('api-createProduct'), $request);

        $response->assertStatus(201)
            ->assertJson([
                'product' => [
                    'name'        => $request['name'],
                    'description' => $request['description'],
                    'price'       => $request['price'],
                ],
            ]);
    }

    /**
     * @test
     * 
     * @group create_product_review
     */
    public function create_product_review()
    {
        $product = $this->createProduct();

        $request = [
            'rating' => 5,
            'comment' => 'Great product!',
            'user_name' => auth()->check() ? trim(auth()->user()->name) : 'guest',
        ];

        $response = $this->post(route('api-createProductReview', ['id' => $product->id]), $request);

        $response->assertStatus(201)
            ->assertJson([
                'review' => [
                    'product_id' => $product->id,
                    'rating'     => $request['rating'],
                    'comment'    => $request['comment'],
                    'user_name'  => $request['user_name'],
                ],
            ]);
    }

    /**
     * @test
     * 
     * @group update_product
     */
    public function update_product()
    {
        $product = $this->createProduct();

        $request = [
            'name' => 'UPDATED: Product Name',
            'description' => 'UPDATED: This is a test product.',
            'price' => 11.22,
        ];

        $response = $this->put(route('api-updateProduct', ['id' => $product->id]), $request);

        $response->assertStatus(200)
            ->assertJson([
                'product' => [
                    'id'          => $product->id,
                    'name'        => $request['name'],
                    'description' => $request['description'],
                    'price'       => $request['price'],
                ],
            ]);
    }

    /**
     * @test
     * 
     * @group delete_product
     */
    public function delete_product()
    {
        $product = $this->createProduct();

        $response = $this->delete(route('api-deleteProduct', ['id' => $product->id]));

        $response->assertStatus(203)
            ->assertJson([
                'product' => [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'description' => $product->description,
                    'price'       => $product->price,
                ],
            ]);
    }
}
