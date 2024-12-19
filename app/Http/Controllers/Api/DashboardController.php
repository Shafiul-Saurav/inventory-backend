<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

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
        $sales_count = 0;

        $data['brand_count'] = $brand_count;
        $data['category_count'] = $category_count;
        $data['supplier_count'] = $supplier_count;
        $data['customer_count'] = $customer_count;
        $data['product_count'] = $product_count;
        $data['sales_count'] = $sales_count;

        return $this->ResponseSuccess($data);
    }
}
