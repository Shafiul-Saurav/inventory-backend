<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;
use App\Repositories\Cart\CartInterface;

class CartController extends Controller
{
    use ApiResponse;

    private $cartRepository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->$cartRepository = $cartRepository;
    }

    public function allCartItems()
    {
        $data = $this->cartRepository->allCartItems();
        $metaData['totalItems'] = count($data);
        $metaData['subtotal'] = Cart::sum('subtotal');

        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    public function addToCart(CartStoreRequest $requestData)
    {
        try {
            $data = $this->cartRepository->addToCart($requestData);
            $metaData['totalItems'] = count($data);
            $metaData['subtotal'] = Cart::sum('subtotal');
            return $this->ResponseSuccess($data, $metaData, 'Cart Item Added Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    public function removeFromCart($id)
    {
        try {
            $data = $this->cartRepository->removeFromCart($id);
            return $this->ResponseSuccess($data, null, 'Card Item Removed Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    public function increaseItemQty($id)
    {
        try {
            $data = $this->cartRepository->increaseItemQty($id);
            return $this->ResponseSuccess($data, null, 'Card Item Incremented Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    public function decreaseItemQty($id)
    {
        try {
            $data = $this->cartRepository->decreaseItemQty($id);
            return $this->ResponseSuccess($data, null, 'Card Item Decremented Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
}
