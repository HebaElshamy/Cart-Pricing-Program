<?php
namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class CartService
{
    protected $totalService;

    public function __construct(TotalService $totalService)
    {
        $this->totalService = $totalService;
    }

    /**
     * Get user's cart items along with total quantity and total amount.
     *
     * @param int $userId
     * @return array
     */
    public function getCartItems($userId)
    {

        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        $totalQuantity = $cartItems->sum('qty');
        $total = $this->calculateOrderTotals($userId);
        return [
            'cartItems' => $cartItems,
            'totalQuantity' => $totalQuantity,
            'total'=>$total,

        ];
    }
      /**
     * Add a product to the user's cart.
     *
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return array
     */
    public function addToCart($userId, $productId, $quantity)
    {
        // Validate input data
        $validator = Validator::make([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ], [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()->first()];
        }

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cartItem) {
            // If the product is found, update the quantity
            $cartItem->qty = $quantity;
            $cartItem->save();
        } else {
            // If the product is not found, create a new record in the cart
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'qty' => $quantity,
            ]);
        }

        // Retrieve updated cart data
        $cartData = $this->getCartItems($userId);

        return [
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'totalQuantity' => $cartData['totalQuantity'],
            'total' => $cartData['total'],
        ];
    }

    public function removeFromCart($userId, $cartItemId)
    {

        // Find and delete the cart item
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $cartItemId)->first();
        if ($cartItem) {
            $cartItem->delete();
             // Retrieve updated cart data
             $cartData = $this->getCartItems($userId);
            return ['success' => true,
             'message' => 'Product deleted from cart successfully.',
             'totalQuantity' => $cartData['totalQuantity'],
             'total' => $cartData['total'],
            ];
        }

        return ['success' => false, 'message' => 'Product not deleted from cart successfully.'];
    }
     /**
     * Calculate order totals including subtotal, VAT, discounts, and shipping.
     *
     * @param int $userId
     * @return array
     */
    public function calculateOrderTotals($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        $subtotal = $this->totalService->calculateSubtotal($cartItems);
        $vat = $this->totalService->calculateVAT($subtotal, 14);
        $shipping = $this->totalService->calculateShipping($cartItems);
        $discounts = $this->totalService->calculateDiscounts($cartItems,$shipping);
        $total = $this->totalService->calculateTotal($subtotal, $vat, $discounts, $shipping);

        return [
            'subtotal' => $subtotal,
            'vat' => $vat,
            'discounts' => $discounts,
            'shipping' => $shipping,
            'total' => $total,
        ];
    }

}

