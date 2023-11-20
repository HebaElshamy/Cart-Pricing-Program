<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve products, cart items, total quantity, and total cost
        $products = Product::select('id', 'name', 'stock', 'price')->get();
        $cart = $this->cartService->getCartItems(Auth::user()->id);
        $totalQuantity = $cart['totalQuantity'];
        $cartItems = $cart['cartItems'];
        $total = $cart['total'];

        // Pass data to the cart view
        return view('cart', compact('products', 'cartItems', 'totalQuantity', 'total'));
    }

    /**
     * Add a product to the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\CartService $cartService
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request, CartService $cartService): JsonResponse
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Add the product to the cart
        $result = $cartService->addToCart(Auth::user()->id, $productId, $quantity);

        // Check if the operation was successful and return the result
        return $result['success']
            ? response()->json([
                'success' => true,
                'message' => $result['message'],
                'totalQuantity' => $result['totalQuantity'],
                'total' => $result['total'],
            ])
            : response()->json(['success' => false, 'message' => $result['message']]);
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $cartItemId
     * @param \App\Services\CartService $cartService
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart($cartItemId, CartService $cartService): JsonResponse
    {
        // Remove the product from the cart
        $result = $cartService->removeFromCart(Auth::user()->id, $cartItemId);

        // Check if the operation was successful and return the result
        return $result['success']
            ? response()->json([
                'success' => true,
                'message' => $result['message'],
                'totalQuantity' => $result['totalQuantity'],
                'total' => $result['total'],
            ])
            : response()->json(['success' => false, 'message' => $result['message']]);
    }
}
