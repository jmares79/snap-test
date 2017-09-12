<?php

namespace App\Service;

use Illuminate\Support\Collection;
use App\Interfaces\CheckoutInterface;
use App\Exceptions\CheckoutScanningException;
use App\Service\ProductService;
use App\Checkout;

class CheckoutService implements CheckoutInterface
{
    protected $product;

    public function __construct(ProductService $product)
    {
        $this->product = $product;
    }

    /**
     * Creates a new checkout row
     *
     * @param string $productCode
     *
     * @return void
     * @throws CheckoutScanningException On scanning error
     */
    public function scan($productCode)
    {
        $checkout = new Checkout;

        $checkout->product_code = $productCode;

        if (!$checkout->save()) throw new CheckoutScanningException();
    }

    /**
     * Calculates the total price
     *
     * @return void
     * @throws CheckoutScanningException On scanning error
     */
    public function total()
    {
        $checkouts = \App\Checkout::all();
        $transactions = $this->processTransactions($checkouts);
        $total = $this->calculateTotalPrice($transactions);

        $this->markTransactionsAsProcessed($checkouts);

        return $total;
    }

    public function markTransactionsAsProcessed($checkouts)
    {
        foreach ($checkouts as $checkout) {
            $checkout->processed = true;
            $checkout->save();
        }
    }

    protected function processTransactions(Collection $transactions)
    {
        $grouped = [];
        $transactions = $transactions->groupBy('product_code')->toArray();

        foreach ($transactions as $item => $values) {
            $grouped[$item] = count($values);
        }

        return $grouped;
    }

    protected function calculateTotalPrice($transactions)
    {
        $total = 0.0;
        $price = 0.0;

        foreach ($transactions as $product => $quantity) {
            $price = $this->product->getPrice($product, $quantity);
            $total += $price * $quantity;
        }

        return $total;
    }
}
