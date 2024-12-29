<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = [];
        $brand_count = Brand::count();
        $category_count = Category::count();
        $supplier_count = User::supplier()->count();
        $customer_count = User::customer()->count();
        $product_count = Product::count();
        $sales_count = Order::count();

        $data['brand_count'] = $brand_count;
        $data['category_count'] = $category_count;
        $data['supplier_count'] = $supplier_count;
        $data['customer_count'] = $customer_count;
        $data['product_count'] = $product_count;
        $data['sales_count'] = $sales_count;

        return $this->ResponseSuccess($data);
    }
}
