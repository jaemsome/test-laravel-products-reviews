<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Review;

class ReviewTest extends TestCase
{
    /**
     * @test
     * 
     * @group create_product_view
     */
    public function create_product_view()
    {
        $product = Product::factory()->create();
        $new_review = [
            'rating' => 5,
            'comment' => 'Great product!',
            'product_id' => $product->id,
        ];

        $review = Review::create($new_review);

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'product_id' => $product->id]);
    }
}
