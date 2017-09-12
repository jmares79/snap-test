<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;

class CheckoutControllerTest extends TestCase
{
    const TOTAL = 16.61;

    /**
     * Tests getTotal method of CheckoutController.
     * The test prepares, via TestCase, the DDBB with specific seed values.
     *
     * @return void
     */
    public function testGetTotal()
    {
        $response = $this->get(route('get-total'));
        $r = json_decode($response->getContent());

        $this->assertEquals(self::TOTAL, $r->total);
    }

    /**
     * Tests the HTTP POST scan an item
     *
     * @dataProvider scanItemProvider
     *
     * @return void
     */
    public function testScanItem($httpStatus, $payload)
    {
        $response = $this->json('POST', route('scan-item'), $payload);

        $response->assertStatus($httpStatus);
    }

    public function scanItemProvider()
    {
        $validPayload = ["product_code" => "CF1"];
        $invalidPayload = ["dummy_field" => "something"];

        return array(
            array(Response::HTTP_CREATED, $validPayload),
            array(Response::HTTP_UNPROCESSABLE_ENTITY, $invalidPayload)
        );
    }
}
