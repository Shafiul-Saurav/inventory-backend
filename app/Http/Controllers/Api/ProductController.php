<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\Product\ProductInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    private $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allProducts()
    {
        $data = $this->productRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data, Found!', 200, 'error');
        }
        return $this->ResponseSuccess(ProductResource::collection($data), $metaData);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('perpage');
        $data = $this->productRepository->allPaginate($perPage);
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data, Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->productRepository->store($request);
            return $this->ResponseSuccess(new ProductResource($data), null, 'Data Stored Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->productRepository->show($id);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new ProductResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $this->productRepository->update($request, $id);
            return $this->ResponseSuccess(new ProductResource($data), null, 'Data Updated Successfully!', 200);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = $this->productRepository->delete($id);
            return $this->ResponseSuccess(new ProductResource($data), null, 'Data Deleted Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Change status of specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $data = $this->productRepository->status($id);
            return $this->ResponseSuccess(new ProductResource($data), null, 'Status Changed Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
}
