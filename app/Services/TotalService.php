<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\Country;
use App\Models\Product;

class TotalService
{
    /**
     * Calculate the subtotal of cart items.
     *
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return float
     */
    public function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(function ($cartItem) {
            // Calculate the product of price and quantity for each item
            return number_format(($cartItem->product->price * $cartItem->qty), 3);
        });
    }

    /**
     * Calculate VAT based on subtotal and VAT rate.
     *
     * @param float $subtotal
     * @param float $vatRate
     * @return float
     */
    public function calculateVAT($subtotal, $vatRate)
    {
        // Calculate VAT amount based on the given rate
        return number_format($subtotal * ($vatRate / 100), 3);
    }

    /**
     * Calculate the shipping cost for cart items.
     *
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return float
     */
    public function calculateShipping($cartItems)
    {
        $shipping = 0;

        foreach ($cartItems as $cartItem) {
            // Retrieve product details
            $product = Product::where('id', $cartItem->product_id)->first();
            $weight = (float) $product->weight;
            $shippingRate = $product->Country->shipping_rate;
            $qty = (float) $cartItem->qty;

            // Calculate shipping cost for each item and accumulate
            $shipping += number_format(($weight * 10) * ($qty) * ($shippingRate), 3);
        }

        return $shipping;
    }

    /**
     * Calculate discounts based on specific conditions.
     *
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @param float $shipping
     * @return array
     */
    public function calculateDiscounts($cartItems, $shipping)
    {
        $discounts = [];
        $total = 0;

        // Define product types for discounts
        $productTop = Product::select('id')->where('type', 'Top')->get();
        $productJacket = Product::select('id', 'price')->where('name', 'Jacket')->get();
        $productShoes = Product::select('id', 'price')->where('name', 'Shoes')->get();

        // Exclude Jacket IDs from Top IDs
        $productTop = $productTop->diff($productJacket);

        // Check for conditions and calculate discounts
        if ($cartItems->sum('qty') >= 2) {
            $total += 10;
            $discounts[] = ['$10 off shipping:' => 10];
        }

        $hasTopProducts = $cartItems->whereIn('product_id', $productTop->pluck('id'))->count() >= 2;
        $hasJacketProduct = $cartItems->whereIn('product_id', $productJacket->pluck('id'))->count() > 0;
        $hasShoesProduct = $cartItems->whereIn('product_id', $productShoes->pluck('id'))->count() > 0;

        if ($hasTopProducts && $hasJacketProduct) {
            $qty = $cartItems->whereIn('product_id', $productJacket->pluck('id'))->sum('qty');
            $price = $productJacket->value('price');
            $total += $price * $qty * 0.5;
            $discounts[] = ['50% off jacket:' => number_format($price * $qty * 0.5, 3)];
        }

        if ($hasShoesProduct) {
            $qty = $cartItems->whereIn('product_id', $productShoes->pluck('id'))->sum('qty');
            $price = $productShoes->value('price');
            $discounts[] = ['10% off shoes:' => number_format($price * $qty * 0.1, 3)];
            $total += $price * $qty * 0.1;
        }

        $discounts[] = ['total' => number_format($total, 3)];

        // Combine discounts into a single array
        $discounts = array_reduce($discounts, function ($carry, $item) {
            return array_merge($carry, $item);
        }, []);

        return $discounts;
    }

    /**
     * Calculate the total cost based on subtotal, VAT, discounts, and shipping.
     *
     * @param float $subtotal
     * @param float $vat
     * @param array $discounts
     * @param float $shipping
     * @return float
     */
    public function calculateTotal($subtotal, $vat, $discounts, $shipping)
    {
        // Apply discounts to the total cost
        if ($discounts) {
            return number_format($subtotal + $vat + $shipping - $discounts['total'], 3);
        } else {
            return number_format($subtotal + $vat + $shipping - 0, 3);
        }
    }
}
