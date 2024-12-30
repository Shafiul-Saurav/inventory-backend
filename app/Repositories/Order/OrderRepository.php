<?php

namespace App\Repositories\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\User as Customer;
use Illuminate\Support\Facades\Hash;

class OrderRepository implements OrderInterface
{
    /*
    * @return mixed|void
    */
    public function all()
    {
        $data = Order::with([
            'order_details',
            'customer'
        ])
        ->latest('id')->get();

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function allPaginate($perPage)
    {
        $data = Order::with([
            'order_details',
            'customer'
        ])
        ->latest('id')
        ->when(request('search'), function($query) {
            $query->where('transaction_number', 'like', '%'.request('search').'%')
            ->orWhere('created_at', 'like', '%'.request('search').'%');
        })
        ->paginate($perPage);

        return $data;
    }

    /*
    * @return mixed|void
    */
    public function show($id)
    {
        $data = Order::with(['order_details'])->findOrFail($id);

        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */
    public function store($requestData)
    {

        // Check If Customer Already Exist
        $customer_mobile = $requestData->customer_mobile;
        $customer = Customer::customer()->where(['phone' => $customer_mobile])->first();

        if (!$customer) {
            $customer = Customer::create([
                'name' => $requestData->customer_name ?? 'Walk in Customer',
                // 'email' => '',
                'role_id' => Customer::CUSTOMER,
                'phone' => $customer_mobile,
                'password' => Hash::make(1234)
            ]);
        }

        $data = Order::create([
            'customer_id' => $customer->id,
            'pay_amount' => $requestData->pay_amount,
            'due_amount' => $requestData->due_amount,
            'subtotal' => $requestData->subtotal,
            'discount' => $requestData->discount,
            'total' => $requestData->total,
            'transaction_number' => $requestData->transaction_number,
            'payment_mathod' => $requestData->payment_mathod,
        ]);

        // Get all Cart Item
        $cartItems = Cart::all();

        foreach ($cartItems as $key => $item) {
            OrderDetails::create([
                'order_id' => $data->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
            ]);

            // decrease product stock from product table
            Product::find($item->product_id)->decrement('stock', $item->qty);
            $item->delete();
        }

        return $this->show($data->id);
    }
}
