<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;

class CartRepository implements CartInterface
{

    /*
    * @return mixed|void
    */
    public function allCartItems()
    {
        $data = Cart::with(['product:id,name,sell_price,code'])->get();

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function addToCart($requestData)
    {
        $product_id = $requestData->product_id;
        $product = Product::find($product_id);

        //Chech if already product added on card or not
        $check = Cart::where(['product_id' => $product_id])->first();
        if ($check) {
            // Increase Cart Qty
            $check->increment('qty');
            $check->update([
                'subtotal' => $check->qty*$check->price,
            ]);

            return $check;
        } else {
            $cart = Cart::create([
                'product_id' => $requestData->product_id,
                'product_name' => $requestData->product_name,
                'qty' => $requestData->qty,
                'price' => $requestData->price,
                'subtotal' => $requestData->subtotal,
            ]);

            return $cart;
        }
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function removeFromCart($id)
    {
        $data = Cart::findOrFail($id);

        $data->delete();

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function increaseItemQty($id)
    {
        $data = Cart::findOrFail($id);
        $data->increment('qty');
        $data->update([
            'subtotal' => $data->qty*$data->price,
        ]);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function decreaseItemQty($id)
    {
        $data = Cart::findOrFail($id);
        $data->decrement('qty');
        $data->update([
            'subtotal' => $data->qty*$data->price,
        ]);

        return $data;
    }
}
