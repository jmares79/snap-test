<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CreatePromotionPost;
use App\Exceptions\PromotionCreationException;
use App\Service\PromotionService;

class PromotionController extends Controller
{
    protected $promotion;

    public function __construct(PromotionService $promotion)
    {
        $this->promotion = $promotion;
    }

    public function create(CreatePromotionPost $request)
    {
        $payload = json_decode($request->getContent());

        try {
            $this->promotion->create($payload);

            return response()->json(['message' => "Promotion created sucessfully"], Response::HTTP_CREATED);
        } catch (PromotionCreationException $e) {
            return response()->json(['message' => "Error while creating promotion"], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(['message' => "Error while creating promotion"], Response::HTTP_BAD_REQUEST);
        }
    }
}
