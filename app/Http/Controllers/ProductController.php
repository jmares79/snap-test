<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CreateProductPost;
use App\Exceptions\ProductCreationException;
use App\Service\ProductService;

/**
 * @resource Product
 *
 * Checkout controller to handle all needed operations for products
 */
class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $product)
    {
        $this->product = $product;
    }

    public function create(CreateProductPost $request)
    {
        $payload = json_decode($request->getContent());

        try {
            $this->product->create($payload);

            return response()->json(['message' => "Product created sucessfully"], Response::HTTP_CREATED);
        } catch (ProductCreationException $e) {
            return response()->json(['message' => "Error while creating product"], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(['message' => "Error while creating product"], Response::HTTP_BAD_REQUEST);
        }
    }
}
