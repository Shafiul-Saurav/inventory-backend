<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Resources\BrandResource;
use App\Repositories\Brand\BrandInterface;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ApiResponse;

    private $brandRepository;

    public function __construct(BrandInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function allBrands()
    {
        $data = $this->brandRepository->all();
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(BrandResource::collection($data), $metaData);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = request('perpage');
        $data = $this->brandRepository->allPaginate($perpage);
        $metaData['count'] = count($data);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess($data, $metaData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
    {
        try {
            $data = $this->brandRepository->store($request);
            return $this->ResponseSuccess(new BrandResource($data), null, 'Brand Stored Successfully!', 201);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->brandRepository->show($id);
        if (!$data) {
            return $this->ResponseError([], null, 'No Data Found!', 200, 'error');
        }
        return $this->ResponseSuccess(new BrandResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, string $id)
    {
        try {
            $data = $this->brandRepository->update($request, $id);
            return $this->ResponseSuccess(new BrandResource($data), null, 'Brand Updated Successfully!', 200);
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
            $data = $this->brandRepository->delete($id);
            return $this->ResponseSuccess(new BrandResource($data), null, 'Brand Deleted Successfully!', 204);
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
            $data = $this->brandRepository->status($id);
            return $this->ResponseSuccess(new BrandResource($data), null, 'Status Updated Successfully!', 204);
        } catch (\Exception $e) {
            return $this->ResponseError($e->getMessage());
        }
    }
}
