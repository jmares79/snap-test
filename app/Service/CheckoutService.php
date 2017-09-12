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
     * @return float $total
     */
    public function total()
    {
        $checkouts = \App\Checkout::where('processed', false);

        $transactions = $this->processTransactions($checkouts);
        $total = $this->calculateTotalPrice($transactions);

        $this->markTransactionsAsProcessed($checkouts);

        return $total;
    }

    /**
     * Mark the transactions as completed
     *
     * @param Collection $checkouts The checkouts to be marked as processed
     *
     * @return void
     */
    protected function markTransactionsAsProcessed(Collection $checkouts)
    {
        foreach ($checkouts as $checkout) {
            $checkout->processed = true;
            $checkout->save();
        }
    }

    /**
     * Process the transactions, grouping them in an easily processable array
     *
     * @param Collection $transactions The transactions to be grouped
     *
     * @return mixed $grouped
     */
    protected function processTransactions(Collection $transactions)
    {
        $grouped = [];
        $transactions = $transactions->groupBy('product_code')->toArray();

        foreach ($transactions as $item => $values) {
            $grouped[$item] = count($values);
        }

        return $grouped;
    }

    /**
     * Perform the calculation of the total price
     *
     * @param Collection $transactions The transactions to be processed for calculating the total
     *
     * @return float $total
     */
    protected function calculateTotalPrice(Collection $transactions)
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
