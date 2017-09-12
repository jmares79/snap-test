<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CreatePromotionPost;
use App\Exceptions\CheckoutScanningException;
use App\Http\Requests\ScanItemPost;
use App\Service\CheckoutService;

/**
 * @resource Checkout
 *
 * Checkout controller to handle all needed operations for loading scanned items
 */
class CheckoutController extends Controller
{
    protected $checkout;

    public function __construct(CheckoutService $checkout)
    {
        $this->checkout = $checkout;
    }

    public function scanItem(ScanItemPost $request)
    {
        $payload = json_decode($request->getContent());

        try {
            $this->checkout->scan($payload->product_code);

            return response()->json(['message' => "Product scanned sucessfully"], Response::HTTP_CREATED);
        } catch (CheckoutScanningException $e) {
            return response()->json(['message' => "Error while scanning product"], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(['message' => "Error while scanning product"], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getTotal(Request $request)
    {
        try {
            $total = $this->checkout->total();

            return response()->json(['total' => $total], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => "Error while scanning product"], Response::HTTP_BAD_REQUEST);
        }
    }
}
