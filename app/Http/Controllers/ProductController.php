<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\CreateProductReviewRequest;
use App\Models\Product;
use App\Models\Review;

class ProductController extends Controller
{
    public function getProductsList(Request $request)
    {
        $response = ['products' => []];
        $status = 200;

        try {
            $response['products'] = Product::with('reviews')->get();
        } catch(Exception $e) {
            $response['error'] = $e->getMessage();
            $status = 500;
        }

        return response()->json($response, $status);
    }
    
    public function getProduct(int $id=0)
    {
        $response = ['product' => NULL];
        $status = 200;

        $product = Product::with('reviews')->find($id);

        if($product) {
            $response['product'] = $product;
        }
        else {
            $response['error'] = 'Failed to find Product ID: '.$id;
            $status = 404;
        }

        return response()->json($response, $status);
    }

    public function createProduct(CreateProductRequest $request)
    {
        $response = ['product' => null];
        $status = 201;

        $validated = $request->validated();
        if( count($validated) > 0 ) {
            $name        = trim($validated['name']);
            $description = !empty($validated['description']) ? trim($validated['description']) : NULL;
            $price       = trim($validated['price']);

            $new_product = new Product;
            $new_product->name = $name;
            $new_product->description = $description;
            $new_product->price = $price;

            if( $new_product->save() ) {
                $response['product'] = $new_product;
            }
            else {
                $status = 500;
                $response['errors'] = 'Failed to add new product: '.json_encode($new_product);
            }
        }

        return response()->json($response, $status);
    }

    public function createProductReview(CreateProductReviewRequest $request, int $id=0)
    {
        $response = ['review' => null];
        $status = 201;

        $product = Product::find($id);

        if($product) {
            $validated = $request->validated();
            if( count($validated) > 0 ) {
                $rating   = trim($validated['rating']);
                $comment  = !empty($validated['comment']) ? trim($validated['comment']) : NULL;
                $username = auth()->check() ? trim(auth()->user()->name) : 'guest';

                $new_review = new Review;
                $new_review->product_id = $product->id;
                $new_review->user_name  = $username;
                $new_review->rating     = $rating;
                $new_review->comment    = $comment;

                if( $product->reviews()->save($new_review) ) {
                    $response['review'] = $new_review;
                }
                else {
                    $status = 500;
                    $response['errors'] = 'Failed to add new review: '.json_encode($new_review);
                }
            }
        }
        else {
            $response['error'] = 'Failed to find Product ID: '.$id;
            $status = 404;
        }

        return response()->json($response, $status);
    }

    public function updateProduct(UpdateProductRequest $request, int $id=0)
    {
        $response = ['product' => null];
        $status = 200;

        $product = Product::find($id);

        if($product) {
            $validated = $request->validated();
            if( count($validated) > 0 ) {
                $name        = trim($validated['name']);
                $description = !empty($validated['description']) ? trim($validated['description']) : NULL;
                $price       = trim($validated['price']);

                $product->name = $name;
                $product->description = $description;
                $product->price = $price;

                if( $product->save() ) {
                    $response['product'] = $product;
                }
                else {
                    $status = 500;
                    $response['errors'] = 'Failed to update product: '.json_encode($product);
                }
            }
        }
        else {
            $response['error'] = 'Failed to find Product ID: '.$id;
            $status = 404;
        }

        return response()->json($response, $status);
    }

    public function deleteProduct(int $id=0)
    {
        $response = ['product' => NULL];
        $status = 203;

        $product = Product::find($id);

        if($product) {
            if( $product->delete() ) {
                $response['product'] = $product;
            }
            else {
                $status = 500;
                $response['errors'] = 'Failed to delete product: '.json_encode($product);
            }
        }
        else {
            $response['error'] = 'Failed to find Product ID: '.$id;
            $status = 404;
        }

        return response()->json($response, $status);
    }
}
