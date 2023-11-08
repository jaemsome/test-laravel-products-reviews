<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\CreateProductReviewRequest;

class ProductRequestsValidationTest extends TestCase
{
    use RefreshDatabase;

    public function validateRequest(array $params=[], $request=NULL)
    {
        if( !empty($request) ) {
            $request->replace($params);

            $validate = $this->app['validator']->make($request->all(), $request->rules());

            return $validate;
        }
        
        return NULL;
    }

    public function validateProductRequest(array $params=[], $request=NULL, string $method_to_assert='passes')
    {
        $this->assertTrue(in_array(get_class($request), [
            CreateProductRequest::class,
            UpdateProductRequest::class,
            CreateProductReviewRequest::class
        ]));

        $validation = $this->validateRequest($params, $request);

        $this->assertTrue(!empty($method_to_assert));

        $this->assertTrue($validation->$method_to_assert());
    }

    /**
     * @test
     * 
     * @group create_product
     * @group update_product
     */
    public function valid_create_update_product_request()
    {
        // With description
        $params = [
            'name' => 'Valid Product',
            'description' => 'A valid product description.',
            'price' => 10.99,
        ];
        $this->validateProductRequest($params, (new CreateProductRequest));
        $this->validateProductRequest($params, (new UpdateProductRequest));

        // Without description
        $params = [
            'name' => 'Valid Product',
            'price' => 10.99,
        ];
        $this->validateProductRequest($params, (new CreateProductRequest));
        $this->validateProductRequest($params, (new UpdateProductRequest));
        
    }

    /**
     * @test
     * 
     * @group create_product
     * @group update_product
     * @group create_product_review
     */
    public function empty_create_update_product_request()
    {
        $params = [];
        $this->validateProductRequest($params, (new CreateProductRequest), 'fails');
        $this->validateProductRequest($params, (new UpdateProductRequest), 'fails');
        $this->validateProductRequest($params, (new CreateProductReviewRequest), 'fails');
    }

    /**
     * @test
     * 
     * @group create_product
     * @group update_product
     */
    public function invalid_create_update_product_request()
    {
        $params = [
            'name'        => 'Invalid Product',
            'description' => 12345, // Invalid data type
            'price'       => -5, // Price cannot be negative
        ];

        $this->validateProductRequest($params, (new CreateProductRequest), 'fails');
        $this->validateProductRequest($params, (new UpdateProductRequest), 'fails');
    }

    /**
     * @test
     * 
     * @group create_product_review
     */
    public function valid_create_product_review_request()
    {
        // With comment
        $params = [
            'rating'  => 1,
            'comment' => 'A valid product comment.',
        ];
        $this->validateProductRequest($params, (new CreateProductReviewRequest));

        // Without comment
        $params = [
            'rating' => 5,
        ];
        $this->validateProductRequest($params, (new CreateProductReviewRequest));
    }

    /**
     * @test
     * 
     * @group create_product_review
     */
    public function invalid_create_product_review_request()
    {
        // Out of range {1-5} rating
        $params = [
            'rating'  => 0,
        ];
        $this->validateProductRequest($params, (new CreateProductReviewRequest), 'fails');
        
        // Missing rating
        $params = [
            'comment' => 'This is a valid product comment.',
        ];
        $this->validateProductRequest($params, (new CreateProductReviewRequest), 'fails');
        
        // Invalid comment type
        $params = [
            'rating'  => 5,
            'comment' => 12345,
        ];
        $this->validateProductRequest($params, (new CreateProductReviewRequest), 'fails');
    }
}
